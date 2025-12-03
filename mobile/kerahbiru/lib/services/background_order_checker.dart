import 'dart:async';
import 'package:shared_preferences/shared_preferences.dart';
import 'api_service.dart';
import 'notification_service.dart';

class BackgroundOrderChecker {
  static Timer? _timer;
  static List<int> _notifiedOrders = [];

  static Future<void> startChecking() async {
    _timer?.cancel();

    final prefs = await SharedPreferences.getInstance();
    final notifiedIds = prefs.getStringList('notified_orders') ?? [];
    _notifiedOrders = notifiedIds.map((e) => int.parse(e)).toList();

    _timer = Timer.periodic(const Duration(seconds: 30), (timer) async {
      await _checkOrderStatus();
    });

    print('✅ Background order checker started');
  }

  static Future<void> _checkOrderStatus() async {
    try {
      final response = await ApiService.getUserOrders();

      if (response['success'] == true) {
        final orders =
            List<Map<String, dynamic>>.from(response['orders'] ?? []);

        for (var order in orders) {
          final orderId = order['id'];
          final status = order['status'];
          final workerName = order['worker']?['name'] ?? 'Pekerja';

          if (!_notifiedOrders.contains(orderId)) {
            if (status == 'accepted') {
              await NotificationService.showNotification(
                title: 'Pesanan Dikonfirmasi!',
                body: '$workerName telah menerima pesanan Anda',
                type: NotificationType.success,
              );
              _notifiedOrders.add(orderId);
              await _saveNotifiedOrders();
            } else if (status == 'cancelled') {
              await NotificationService.showNotification(
                title: '✗ Pesanan Dibatalkan',
                body: 'Pesanan dengan $workerName telah dibatalkan',
                type: NotificationType.error,
              );
              _notifiedOrders.add(orderId);
              await _saveNotifiedOrders();
            }
          }
        }
      }
    } catch (e) {
      print('❌ Background check error: $e');
    }
  }

  static Future<void> _saveNotifiedOrders() async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.setStringList(
      'notified_orders',
      _notifiedOrders.map((e) => e.toString()).toList(),
    );
  }

  static void stopChecking() {
    _timer?.cancel();
    print('🛑 Background order checker stopped');
  }

  static Future<void> clearOldNotifications() async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.remove('notified_orders');
    _notifiedOrders.clear();
  }
}
