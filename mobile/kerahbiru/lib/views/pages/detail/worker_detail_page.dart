import 'package:flutter/material.dart';
import 'package:url_launcher/url_launcher.dart';
import '../../../services/api_service.dart';
import '../../../widgets/custom_snackbar.dart';
import '../../../utils/database/favorite_database.dart';
import '../../../utils/helpers/currency_helper.dart';
import '../../../utils/helpers/timezone_helper.dart';
import '../../../utils/helpers/image_helper.dart';
import '../../../utils/user_preferences.dart';
import '../order_page.dart';

class WorkerDetailPage extends StatefulWidget {
  final Map<String, dynamic> worker;

  const WorkerDetailPage({super.key, required this.worker});

  @override
  State<WorkerDetailPage> createState() => _WorkerDetailPageState();
}

class _WorkerDetailPageState extends State<WorkerDetailPage> {
  bool isFavorite = false;
  bool isLoadingFavorite = true;
  bool isLoadingReviews = false;
  String currentCurrency = 'IDR';
  String currentTimezone = 'Asia/Jakarta';
  int? currentUserId;
  List<Map<String, dynamic>> reviews = [];

  double calculatedRating = 0.0;
  int totalReviews = 0;

  @override
  void initState() {
    super.initState();
    _initializeData();
  }

  Future<void> _initializeData() async {
    await Future.wait([
      _loadUserId(),
      _loadCurrency(),
      _loadTimezone(),
    ]);

    if (currentUserId != null) {
      await _checkFavorite();
    }

    await _loadWorkerDetail();
  }

  Future<void> _loadUserId() async {
    final userId = await UserPreferences.getUserId();
    if (mounted) {
      setState(() => currentUserId = userId);
    }
  }

  Future<void> _loadCurrency() async {
    final currency = await UserPreferences.getCurrency();
    if (mounted) {
      setState(() => currentCurrency = currency);
    }
  }

  Future<void> _loadTimezone() async {
    final tz = await UserPreferences.getTimezone();
    if (mounted) {
      setState(() => currentTimezone = tz);
    }
  }

  Future<void> _checkFavorite() async {
    if (currentUserId == null) {
      setState(() => isLoadingFavorite = false);
      return;
    }

    try {
      final result = await FavoriteDatabase.isFavorite(
        widget.worker['id'],
        currentUserId!,
      );
      if (mounted) {
        setState(() {
          isFavorite = result;
          isLoadingFavorite = false;
        });
      }
    } catch (e) {
      debugPrint('❌ Error checking favorite: $e');
      if (mounted) {
        setState(() => isLoadingFavorite = false);
      }
    }
  }

  Future<void> _loadWorkerDetail() async {
    try {
      final response = await ApiService.getWorkerDetail(widget.worker['id']);

      if (response['success'] == true) {
        final worker = response['worker'];

        setState(() {
          calculatedRating =
              double.tryParse(worker['calculated_rating'].toString()) ?? 0.0;

          totalReviews = response['total_reviews'] ?? 0;

          reviews = List<Map<String, dynamic>>.from(response['reviews'] ?? []);
        });
      }
    } catch (e) {
      debugPrint('❌ Error load worker detail: $e');
    }
  }

  Future<void> _toggleFavorite() async {
    if (currentUserId == null) {
      CustomSnackbar.show(
        context,
        message: 'User ID tidak ditemukan!',
        backgroundColor: Colors.red,
      );
      return;
    }

    try {
      if (isFavorite) {
        await FavoriteDatabase.removeFavorite(
          widget.worker['id'],
          currentUserId!,
        );
        if (mounted) {
          CustomSnackbar.show(
            context,
            message: '${widget.worker['name']} dihapus dari favorit!',
            backgroundColor: Colors.red,
          );
        }
      } else {
        await FavoriteDatabase.addFavorite(widget.worker, currentUserId!);
        if (mounted) {
          CustomSnackbar.show(
            context,
            message: '${widget.worker['name']} ditambahkan ke favorit!',
            backgroundColor: Colors.green,
          );
        }
      }

      if (mounted) {
        setState(() => isFavorite = !isFavorite);
      }
    } catch (e) {
      debugPrint('❌ Error toggling favorite: $e');
      if (mounted) {
        CustomSnackbar.show(
          context,
          message: 'Gagal memperbarui favorit!',
          backgroundColor: Colors.red,
        );
      }
    }
  }

  String _censorName(String? fullName) {
    if (fullName == null || fullName.isEmpty) return 'P***';
    final name = fullName.split(' ').first;
    return '${name[0].toUpperCase()}***';
  }

  Future<void> _loadReviews() async {
    if (!mounted) return;

    setState(() => isLoadingReviews = true);

    try {
      final response = await ApiService.getUserOrders().timeout(
        const Duration(seconds: 10),
        onTimeout: () {
          debugPrint('⏱️ Orders loading timeout');
          return {'success': false, 'message': 'Timeout'};
        },
      );

      if (response['success'] == true && mounted) {
        final allOrders =
            List<Map<String, dynamic>>.from(response['orders'] ?? []);

        final workerOrders = allOrders.where((order) {
          return order['worker_id'] == widget.worker['id'] &&
              order['user_rating'] != null &&
              order['status'] == 'completed';
        }).toList();

        reviews = workerOrders.map((order) {
          String userName = 'Pengguna';
          if (order['user'] != null && order['user']['name'] != null) {
            userName = order['user']['name'];
          }

          return {
            'user_name': userName,
            'user_rating': order['user_rating'],
            'user_review': order['user_review'] ?? '',
            'created_at': order['work_completed_at'] ?? order['updated_at'],
          };
        }).toList();

        if (reviews.isNotEmpty) {
          double totalRating = 0;
          for (var review in reviews) {
            totalRating +=
                double.tryParse(review['user_rating'].toString()) ?? 0;
          }
          calculatedRating = totalRating / reviews.length;
          totalReviews = reviews.length;
        } else {
          calculatedRating = 0.0;
          totalReviews = 0;
        }

        setState(() {});

        debugPrint(
            '✅ Loaded ${reviews.length} reviews for worker ${widget.worker['id']}');
      }
    } catch (e) {
      debugPrint('❌ Error loading reviews: $e');
    } finally {
      if (mounted) {
        setState(() => isLoadingReviews = false);
      }
    }
  }

  Widget _reviewCard(String name, String comment, double rating) {
    final censoredName = _censorName(name);

    return Container(
      width: double.infinity,
      margin: const EdgeInsets.only(bottom: 8),
      padding: const EdgeInsets.all(12),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(12),
        border: Border.all(color: Colors.grey[200]!),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            children: [
              CircleAvatar(
                radius: 16,
                backgroundColor: const Color(0xFF4A70A9).withOpacity(0.1),
                child: Text(
                  censoredName.isNotEmpty ? censoredName[0].toUpperCase() : 'P',
                  style: const TextStyle(
                    fontFamily: "Poppins",
                    fontWeight: FontWeight.w600,
                    color: Color(0xFF4A70A9),
                  ),
                ),
              ),
              const SizedBox(width: 8),
              Expanded(
                child: Text(
                  censoredName,
                  style: const TextStyle(
                    fontFamily: "Poppins",
                    fontWeight: FontWeight.w600,
                    fontSize: 13,
                  ),
                ),
              ),
              Row(
                children: [
                  const Icon(Icons.star, color: Colors.amber, size: 14),
                  const SizedBox(width: 2),
                  Text(
                    rating.toStringAsFixed(1),
                    style: const TextStyle(
                      fontSize: 12,
                      fontWeight: FontWeight.w600,
                    ),
                  ),
                ],
              ),
            ],
          ),
          if (comment.isNotEmpty) ...[
            const SizedBox(height: 8),
            Text(
              comment,
              style: const TextStyle(
                fontFamily: "Poppins",
                fontSize: 12,
                color: Colors.black87,
                height: 1.4,
              ),
            ),
          ],
        ],
      ),
    );
  }

  String formatCurrency(dynamic harga) {
    return CurrencyHelper.convertAndFormat(harga, currentCurrency);
  }

  double parseRating(dynamic rating) {
    if (rating == null) return 0.0;
    return double.tryParse(rating.toString()) ?? 0.0;
  }

  Future<void> openWhatsApp() async {
    final worker = widget.worker;
    final phone = worker['whatsapp'] ?? worker['phone'] ?? '';
    final name = worker['name'] ?? '';

    final cleanPhone = phone.replaceAll(RegExp(r'[^\d]'), '');

    final url = Uri.parse(
      'https://wa.me/$cleanPhone?text=${Uri.encodeComponent("Halo, saya tertarik dengan jasa $name")}',
    );

    try {
      if (await canLaunchUrl(url)) {
        await launchUrl(url, mode: LaunchMode.externalApplication);
      } else {
        throw 'Could not launch WhatsApp';
      }
    } catch (e) {
      debugPrint('❌ WhatsApp launch error: $e');
      if (mounted) {
        CustomSnackbar.show(
          context,
          message: 'Tidak dapat membuka WhatsApp!',
          backgroundColor: Colors.red,
        );
      }
    }
  }

  Widget _timeChip(String text) {
    final convertedTime = TimezoneHelper.convertTime(text, currentTimezone);

    return Chip(
      label: Text(
        convertedTime,
        style: const TextStyle(fontFamily: "Poppins", fontSize: 12),
      ),
      backgroundColor: Colors.white,
      side: const BorderSide(color: Color(0xFF4A70A9), width: 0.5),
    );
  }

  @override
  Widget build(BuildContext context) {
    final worker = widget.worker;

    return Scaffold(
      backgroundColor: const Color(0xFFEFECE3),
      body: Stack(
        children: [
          CustomScrollView(
            slivers: [
              SliverAppBar(
                pinned: true,
                backgroundColor: Colors.white,
                expandedHeight: 250,
                leading: Container(
                  margin: const EdgeInsets.all(10),
                  decoration: const BoxDecoration(
                    color: Colors.white,
                    shape: BoxShape.circle,
                    boxShadow: [
                      BoxShadow(
                        color: Colors.black26,
                        blurRadius: 4,
                        offset: Offset(0, 2),
                      ),
                    ],
                  ),
                  child: IconButton(
                    icon: const Icon(
                      Icons.arrow_back_ios_new_rounded,
                      color: Color(0xFF4A70A9),
                      size: 20,
                    ),
                    onPressed: () => Navigator.pop(context),
                  ),
                ),
                flexibleSpace: FlexibleSpaceBar(
                  background: ImageHelper.buildNetworkImage(
                    photoUrl: worker["photo"],
                    width: double.infinity,
                    height: 250,
                    fit: BoxFit.cover,
                  ),
                ),
              ),
              SliverToBoxAdapter(
                child: Padding(
                  padding:
                      const EdgeInsets.symmetric(horizontal: 20, vertical: 16),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Row(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          Expanded(
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                Text(
                                  worker["name"]?.toString() ?? "Pekerja",
                                  style: const TextStyle(
                                    fontFamily: "Poppins",
                                    fontWeight: FontWeight.w600,
                                    fontSize: 18,
                                  ),
                                ),
                                const SizedBox(height: 2),
                                Text(
                                  worker["job_title"]?.toString() ?? "-",
                                  style: const TextStyle(
                                    fontFamily: "Poppins",
                                    fontSize: 14,
                                    color: Colors.black54,
                                  ),
                                ),
                              ],
                            ),
                          ),
                          Column(
                            crossAxisAlignment: CrossAxisAlignment.end,
                            children: [
                              Text(
                                formatCurrency(worker["price_per_hour"]),
                                style: const TextStyle(
                                  fontFamily: "Poppins",
                                  fontWeight: FontWeight.w700,
                                  color: Color(0xFF4A70A9),
                                  fontSize: 16,
                                ),
                              ),
                              const SizedBox(height: 4),
                              Row(
                                mainAxisSize: MainAxisSize.min,
                                children: [
                                  const Icon(
                                    Icons.location_on_rounded,
                                    color: Color(0xFF4A70A9),
                                    size: 16,
                                  ),
                                  const SizedBox(width: 4),
                                  Text(
                                    "${worker["distance"]?.toString() ?? '0'} km",
                                    style: const TextStyle(
                                      fontFamily: "Poppins",
                                      fontSize: 13,
                                      color: Colors.black87,
                                    ),
                                  ),
                                ],
                              ),
                            ],
                          ),
                        ],
                      ),
                      const SizedBox(height: 16),
                      const Divider(),
                      Text(
                        worker["description"]?.toString() ??
                            "Pekerja profesional dengan pengalaman luas dan hasil kerja berkualitas tinggi.",
                        style: const TextStyle(
                          fontFamily: "Poppins",
                          fontSize: 13,
                          color: Colors.black87,
                          height: 1.4,
                        ),
                      ),
                      const SizedBox(height: 16),
                      const Divider(),
                      Row(
                        children: [
                          const Text(
                            "Waktu Tersedia",
                            style: TextStyle(
                              fontFamily: "Poppins",
                              fontWeight: FontWeight.w600,
                              fontSize: 16,
                            ),
                          ),
                          const SizedBox(width: 8),
                          Container(
                            padding: const EdgeInsets.symmetric(
                              horizontal: 8,
                              vertical: 2,
                            ),
                            decoration: BoxDecoration(
                              color: const Color(0xFF4A70A9).withOpacity(0.1),
                              borderRadius: BorderRadius.circular(8),
                            ),
                            child: Text(
                              TimezoneHelper.getTimezoneLabel(currentTimezone),
                              style: const TextStyle(
                                fontFamily: "Poppins",
                                fontSize: 11,
                                color: Color(0xFF4A70A9),
                                fontWeight: FontWeight.w600,
                              ),
                            ),
                          ),
                        ],
                      ),
                      const SizedBox(height: 8),
                      Wrap(
                        spacing: 8,
                        runSpacing: 8,
                        children: [
                          _timeChip("08:00-10:00"),
                          _timeChip("10:00-12:00"),
                          _timeChip("13:00-15:00"),
                          _timeChip("15:00-17:00"),
                        ],
                      ),
                      const SizedBox(height: 16),
                      const Divider(),
                      Row(
                        mainAxisAlignment: MainAxisAlignment.spaceBetween,
                        children: [
                          const Text(
                            "Ulasan Pelanggan",
                            style: TextStyle(
                              fontFamily: "Poppins",
                              fontWeight: FontWeight.w600,
                              fontSize: 16,
                            ),
                          ),
                          Container(
                            padding: const EdgeInsets.symmetric(
                              horizontal: 12,
                              vertical: 6,
                            ),
                            decoration: BoxDecoration(
                              color: Colors.amber.withOpacity(0.1),
                              borderRadius: BorderRadius.circular(20),
                            ),
                            child: Row(
                              children: [
                                const Icon(
                                  Icons.star_rounded,
                                  color: Colors.amber,
                                  size: 18,
                                ),
                                const SizedBox(width: 4),
                                Text(
                                  calculatedRating > 0
                                      ? "${calculatedRating.toStringAsFixed(1)} / 5.0"
                                      : "0.0 / 5.0",
                                  style: const TextStyle(
                                    fontFamily: "Poppins",
                                    fontSize: 13,
                                    fontWeight: FontWeight.w600,
                                  ),
                                ),
                              ],
                            ),
                          ),
                        ],
                      ),
                      const SizedBox(height: 8),
                      Text(
                        "($totalReviews ulasan)",
                        style: const TextStyle(
                          fontFamily: "Poppins",
                          fontSize: 13,
                          color: Colors.black54,
                        ),
                      ),
                      const SizedBox(height: 12),
                      if (isLoadingReviews)
                        const Center(
                          child: Padding(
                            padding: EdgeInsets.all(20),
                            child: Column(
                              children: [
                                SizedBox(
                                  width: 30,
                                  height: 30,
                                  child: CircularProgressIndicator(
                                    strokeWidth: 3,
                                    color: Color(0xFF4A70A9),
                                  ),
                                ),
                                SizedBox(height: 12),
                                Text(
                                  'Memuat ulasan...',
                                  style: TextStyle(
                                    fontFamily: 'Poppins',
                                    fontSize: 12,
                                    color: Colors.grey,
                                  ),
                                ),
                              ],
                            ),
                          ),
                        )
                      else if (reviews.isEmpty)
                        Container(
                          padding: const EdgeInsets.all(16),
                          decoration: BoxDecoration(
                            color: Colors.grey[100],
                            borderRadius: BorderRadius.circular(12),
                          ),
                          child: const Center(
                            child: Text(
                              'Belum ada ulasan',
                              style: TextStyle(
                                fontFamily: 'Poppins',
                                color: Colors.grey,
                              ),
                            ),
                          ),
                        )
                      else
                        ...reviews.map((review) => _reviewCard(
                              review['user_name'] ?? 'Pengguna',
                              review['user_review'] ?? '',
                              double.tryParse(
                                      review['user_rating'].toString()) ??
                                  0.0,
                            )),
                      const SizedBox(height: 100),
                    ],
                  ),
                ),
              ),
            ],
          ),
          Positioned(
            bottom: 0,
            left: 0,
            right: 0,
            child: Container(
              padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 10),
              decoration: const BoxDecoration(
                color: Colors.white,
                borderRadius: BorderRadius.only(
                  topLeft: Radius.circular(24),
                  topRight: Radius.circular(24),
                ),
                boxShadow: [
                  BoxShadow(
                    color: Colors.black12,
                    offset: Offset(0, -2),
                    blurRadius: 8,
                  ),
                ],
              ),
              child: SafeArea(
                child: Row(
                  children: [
                    SizedBox(
                      width: 60,
                      child: ElevatedButton(
                        onPressed: isLoadingFavorite ? null : _toggleFavorite,
                        style: ElevatedButton.styleFrom(
                          backgroundColor: Colors.white,
                          foregroundColor: const Color(0xFF4A70A9),
                          side: const BorderSide(color: Color(0xFF4A70A9)),
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(12),
                          ),
                          padding: const EdgeInsets.symmetric(vertical: 12),
                        ),
                        child: isLoadingFavorite
                            ? const SizedBox(
                                width: 20,
                                height: 20,
                                child: CircularProgressIndicator(
                                  strokeWidth: 2,
                                  color: Color(0xFF4A70A9),
                                ),
                              )
                            : Icon(
                                isFavorite
                                    ? Icons.favorite
                                    : Icons.favorite_border_rounded,
                                color: isFavorite
                                    ? Colors.red
                                    : const Color(0xFF4A70A9),
                                size: 24,
                              ),
                      ),
                    ),
                    const SizedBox(width: 10),
                    Expanded(
                      child: ElevatedButton.icon(
                        onPressed: () {
                          Navigator.push(
                            context,
                            MaterialPageRoute(
                              builder: (context) => OrderPage(worker: worker),
                            ),
                          );
                        },
                        icon: const Icon(Icons.shopping_bag_rounded),
                        label: const Text(
                          "Pesan Sekarang",
                          style: TextStyle(
                            fontFamily: "Poppins",
                            fontWeight: FontWeight.w500,
                          ),
                        ),
                        style: ElevatedButton.styleFrom(
                          backgroundColor: const Color(0xFF4A70A9),
                          foregroundColor: Colors.white,
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(12),
                          ),
                          padding: const EdgeInsets.symmetric(vertical: 12),
                        ),
                      ),
                    ),
                  ],
                ),
              ),
            ),
          ),
        ],
      ),
    );
  }
}
