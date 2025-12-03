import 'package:flutter/material.dart';
import '../../services/api_service.dart';
import '../../utils/session/session_manager.dart';
import '../../utils/session/session_checker.dart';
import '../../utils/helpers/image_helper.dart';
import '../auth_page.dart';
import 'detail/profile_edit_page.dart';
import '../../widgets/custom_snackbar.dart';
import '../../utils/user_preferences.dart';
import '../../widgets/currency_timezone_picker.dart';

class ProfilePage extends StatefulWidget {
  const ProfilePage({super.key});

  @override
  State<ProfilePage> createState() => _ProfilePageState();
}

class _ProfilePageState extends State<ProfilePage> {
  Map<String, dynamic>? userData;
  bool isLoading = true;

  @override
  void initState() {
    super.initState();
    _loadProfile();
  }

  Future<void> _loadProfile() async {
    if (!mounted) return;

    setState(() => isLoading = true);

    try {
      final response = await ApiService.getProfile();
      if (response['success'] == true && mounted) {
        setState(() {
          userData = response['user'];
        });
      }
    } catch (e) {
      debugPrint('❌ Error loading profile: $e');
    } finally {
      if (mounted) {
        setState(() => isLoading = false);
      }
    }
  }

  String _getTimezoneLabel(String? timezoneCode) {
    if (timezoneCode == null) return 'Indonesia (Jakarta) - WIB (UTC+7)';

    const timezoneLabels = {
      'Asia/Jakarta': 'Indonesia (Jakarta) - WIB (UTC+7)',
      'Asia/Makassar': 'Indonesia (Makassar) - WITA (UTC+8)',
      'Asia/Jayapura': 'Indonesia (Jayapura) - WIT (UTC+9)',
      'America/New_York': 'United States - EST (UTC-5)',
      'Europe/London': 'United Kingdom - GMT (UTC+0)',
    };

    return timezoneLabels[timezoneCode] ?? timezoneCode;
  }

  void _showCurrencyPicker() {
    showCurrencyPicker(
      context: context,
      currentCurrency: userData?['preferred_currency'] ?? 'IDR',
      onCurrencySelected: (currency) async {
        try {
          await UserPreferences.setCurrency(currency);

          ApiService.updatePreferences(currency: currency).then((response) {
            if (response['success'] == true) {
              debugPrint('✅ Currency synced to API');
            }
          });

          if (mounted) {
            CustomSnackbar.show(
              context,
              message: 'Mata uang diubah ke $currency',
              backgroundColor: Colors.green,
            );

            await _loadProfile();
          }
        } catch (e) {
          if (mounted) {
            CustomSnackbar.show(
              context,
              message: 'Error: $e',
              backgroundColor: Colors.red,
            );
          }
        }
      },
    );
  }

  void _showTimezonePicker() {
    showTimezonePicker(
      context: context,
      currentTimezone: userData?['preferred_timezone'] ?? 'Asia/Jakarta',
      onTimezoneSelected: (timezone) async {
        try {
          await UserPreferences.setTimezone(timezone);

          ApiService.updatePreferences(timezone: timezone).then((response) {
            if (response['success'] == true) {
              debugPrint('✅ Timezone synced to API');
            }
          });

          if (mounted) {
            CustomSnackbar.show(
              context,
              message: 'Zona waktu berhasil diubah',
              backgroundColor: Colors.green,
            );

            await _loadProfile();
          }
        } catch (e) {
          if (mounted) {
            CustomSnackbar.show(
              context,
              message: 'Error: $e',
              backgroundColor: Colors.red,
            );
          }
        }
      },
    );
  }

  @override
  Widget build(BuildContext context) {
    if (isLoading) {
      return const Scaffold(
        body: Center(child: CircularProgressIndicator()),
      );
    }

    return Scaffold(
      backgroundColor: const Color(0xFFEFECE3),
      body: Column(
        children: [
          _buildHeader(context),
          const SizedBox(height: 20),
          Expanded(
            child: ListView(
              padding: const EdgeInsets.symmetric(horizontal: 16),
              children: [
                const SizedBox(height: 20),
                _buildSectionTitle("Pengaturan"),
                _buildSettingItem(
                  icon: Icons.attach_money_rounded,
                  title: "Mata Uang",
                  subtitle: userData?['preferred_currency'] ?? "IDR (Rp)",
                  onTap: _showCurrencyPicker,
                ),
                _buildSettingItem(
                  icon: Icons.access_time_rounded,
                  title: "Zona Waktu",
                  subtitle: _getTimezoneLabel(userData?['preferred_timezone']),
                  onTap: _showTimezonePicker,
                ),
                const SizedBox(height: 20),
                _buildSectionTitle("Tentang"),
                _buildSettingItem(
                  icon: Icons.info_outline_rounded,
                  title: "Tentang Developer",
                  onTap: () => _showDevDialog(context),
                ),
                const SizedBox(height: 40),
                _buildLogout(context),
                const SizedBox(height: 20),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildHeader(BuildContext context) {
    return Container(
      padding: EdgeInsets.only(
        left: 16,
        right: 16,
        top: MediaQuery.of(context).padding.top + 10,
        bottom: 25,
      ),
      decoration: const BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.only(
          bottomLeft: Radius.circular(25),
          bottomRight: Radius.circular(25),
        ),
        boxShadow: [
          BoxShadow(color: Colors.black12, blurRadius: 6, offset: Offset(0, 3)),
        ],
      ),
      child: Stack(
        children: [
          Row(
            children: [
              CircleAvatar(
                radius: 45,
                key: ValueKey(userData?['photo'] ?? 'default'),
                backgroundImage: ImageHelper.getNetworkImage(
                  userData?['photo'],
                  defaultAsset: "assets/images/user.jpg",
                ),
              ),
              const SizedBox(width: 16),
              Expanded(
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      userData?['name'] ?? "User",
                      style: const TextStyle(
                          fontSize: 20, fontWeight: FontWeight.bold),
                    ),
                    const SizedBox(height: 4),
                    Text(
                      userData?['email'] ?? "",
                      style: const TextStyle(fontSize: 14, color: Colors.grey),
                      overflow: TextOverflow.ellipsis,
                    ),
                  ],
                ),
              ),
            ],
          ),
          Positioned(
            top: 0,
            right: 0,
            child: IconButton(
              icon: const Icon(Icons.edit, color: Color(0xFF4A70A9)),
              onPressed: () {
                Navigator.push(
                  context,
                  MaterialPageRoute(builder: (_) => const EditProfilePage()),
                ).then((_) {
                  setState(() => isLoading = true);
                  _loadProfile();
                });
              },
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildSectionTitle(String title) {
    return Padding(
      padding: const EdgeInsets.only(left: 4, bottom: 8),
      child: Text(
        title,
        style: const TextStyle(
          fontWeight: FontWeight.bold,
          fontSize: 16,
          color: Colors.black87,
        ),
      ),
    );
  }

  Widget _buildSettingItem({
    required IconData icon,
    required String title,
    String? subtitle,
    required Function() onTap,
  }) {
    Color bgColor = Colors.white;

    return Container(
      margin: const EdgeInsets.only(bottom: 10),
      decoration: BoxDecoration(
        color: bgColor,
        borderRadius: BorderRadius.circular(12),
      ),
      child: ListTile(
        leading: Icon(icon, color: const Color(0xFF4A70A9)),
        title: Text(title),
        subtitle: subtitle != null
            ? Text(subtitle, style: const TextStyle(color: Colors.grey))
            : null,
        trailing: const Icon(Icons.arrow_forward_ios_rounded, size: 18),
        onTap: onTap,
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.circular(12),
        ),
      ),
    );
  }

  Widget _buildLogout(BuildContext context) {
    return ElevatedButton(
      onPressed: () => _showLogoutConfirm(context),
      style: ElevatedButton.styleFrom(
        backgroundColor: Colors.redAccent,
        padding: const EdgeInsets.symmetric(vertical: 14),
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
      ),
      child: const Text(
        "Keluar",
        style: TextStyle(fontSize: 16, color: Colors.white),
      ),
    );
  }

  void _showLogoutConfirm(BuildContext context) {
    showModalBottomSheet(
      context: context,
      shape: const RoundedRectangleBorder(
        borderRadius: BorderRadius.vertical(top: Radius.circular(20)),
      ),
      builder: (context) {
        return Padding(
          padding: const EdgeInsets.all(18),
          child: Column(
            mainAxisSize: MainAxisSize.min,
            children: [
              const Text(
                "Konfirmasi Mengakhiri Sesi",
                style: TextStyle(fontWeight: FontWeight.bold, fontSize: 18),
              ),
              const SizedBox(height: 10),
              const Text(
                "Apakah kamu yakin ingin mengakhiri sesi ini?",
                textAlign: TextAlign.center,
              ),
              const SizedBox(height: 20),
              Row(
                children: [
                  Expanded(
                    child: OutlinedButton(
                      onPressed: () => Navigator.pop(context),
                      child: const Text("Batal"),
                    ),
                  ),
                  const SizedBox(width: 10),
                  Expanded(
                    child: ElevatedButton(
                      style: ElevatedButton.styleFrom(
                        backgroundColor: Colors.redAccent,
                      ),
                      onPressed: () async {
                        Navigator.pop(context);

                        showDialog(
                          context: context,
                          barrierDismissible: false,
                          builder: (_) => const Center(
                            child: CircularProgressIndicator(
                              color: Color(0xFF4A70A9),
                            ),
                          ),
                        );

                        try {
                          await ApiService.logout();
                          await SessionManager.clearSession();
                          await UserPreferences.clearAll();
                          SessionChecker.stopChecking();

                          if (!mounted) return;
                          Navigator.pop(context);

                          if (!mounted) return;

                          await Navigator.of(context).pushAndRemoveUntil(
                            MaterialPageRoute(builder: (_) => const AuthPage()),
                            (route) => false,
                          );

                          Future.delayed(const Duration(milliseconds: 300), () {
                            if (context.mounted) {
                              CustomSnackbar.show(
                                context,
                                message:
                                    'Berhasil mengakhiri sesi. Sampai jumpa lagi!',
                                backgroundColor: Colors.green,
                                duration: const Duration(seconds: 3),
                              );
                            }
                          });
                        } catch (e) {
                          debugPrint('❌ Logout error: $e');

                          if (!context.mounted) return;
                          Navigator.pop(context);

                          CustomSnackbar.show(
                            context,
                            message: 'Error logout: $e',
                            backgroundColor: Colors.red,
                          );
                        }
                      },
                      child: const Text("Keluar"),
                    ),
                  ),
                ],
              ),
            ],
          ),
        );
      },
    );
  }

  void _showDevDialog(BuildContext context) {
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(15)),
        title: const Text("Tentang Developer"),
        content: const Column(
          mainAxisSize: MainAxisSize.min,
          children: [
            CircleAvatar(
              radius: 40,
              backgroundImage: AssetImage("assets/images/Barita.png"),
            ),
            SizedBox(height: 10),
            Text(
              "Barita Davitya Setiawati",
              style: TextStyle(fontWeight: FontWeight.bold),
            ),
            Text("124230073 SI'23"),
            SizedBox(height: 10),
            Text(
              "Saya tidak tau apakah siapa yang akan menjadi pemilik perusahaan bergengsi yang dapat membantu rakyat introvert seperti saya ketika mencari bantuan tukang. Tapi jika sosok itu nanti ada disini, mohon diwujudkan ya. \n\nTerima kasih banyak Pak Bagus dengan tugas yang super sekali. \n\n Terima kasih orang-oarang terdekat saya yang menjadi saksi bisu betapa berusahanya saya menamatkan tugas ini dalam waktu yang sesingkat itu. \n\n Kalau tidak ada mata kuliah ini, mungkin semester 5 saya tidak seberwarna ini.",
              textAlign: TextAlign.justify,
            ),
            SizedBox(height: 10),
            Text(
              " Terima kasih PAM telah hadir mewarnai hidup semester ganjil ini.",
              textAlign: TextAlign.center,
            )
          ],
        ),
        actions: [
          TextButton(
            onPressed: () => Navigator.pop(context),
            child: const Text("Tutup"),
          ),
        ],
      ),
    );
  }
}
