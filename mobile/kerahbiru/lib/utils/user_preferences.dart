import 'package:shared_preferences/shared_preferences.dart';

class UserPreferences {
  static const String _keyUserId = 'user_id';

  static String _keyCurrency(int userId) => 'user_${userId}_currency';
  static String _keyTimezone(int userId) => 'user_${userId}_timezone';

  static const String DEFAULT_CURRENCY = 'IDR';
  static const String DEFAULT_TIMEZONE = 'Asia/Jakarta';

  static Future<int?> getUserId() async {
    final prefs = await SharedPreferences.getInstance();
    return prefs.getInt(_keyUserId);
  }

  static Future<void> setUserId(int userId) async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.setInt(_keyUserId, userId);

    final currencyKey = _keyCurrency(userId);
    final timezoneKey = _keyTimezone(userId);

    if (!prefs.containsKey(currencyKey)) {
      await prefs.setString(currencyKey, DEFAULT_CURRENCY);
      print('✅ Set default currency for user $userId: $DEFAULT_CURRENCY');
    }

    if (!prefs.containsKey(timezoneKey)) {
      await prefs.setString(timezoneKey, DEFAULT_TIMEZONE);
      print('✅ Set default timezone for user $userId: $DEFAULT_TIMEZONE');
    }
  }

  static Future<void> setCurrency(String currency) async {
    final userId = await getUserId();
    if (userId == null) {
      print('❌ Cannot set currency: User ID not found');
      return;
    }

    final prefs = await SharedPreferences.getInstance();
    await prefs.setString(_keyCurrency(userId), currency);
    print('💰 Set currency for user $userId: $currency');
  }

  static Future<String> getCurrency() async {
    final userId = await getUserId();
    if (userId == null) {
      print('⚠️ User ID not found, using default currency');
      return DEFAULT_CURRENCY;
    }

    final prefs = await SharedPreferences.getInstance();
    final currency = prefs.getString(_keyCurrency(userId));

    if (currency == null || currency.isEmpty) {
      await prefs.setString(_keyCurrency(userId), DEFAULT_CURRENCY);
      print('💰 Using default currency for user $userId: $DEFAULT_CURRENCY');
      return DEFAULT_CURRENCY;
    }

    print('💰 Get currency for user $userId: $currency');
    return currency;
  }

  static Future<void> setTimezone(String timezone) async {
    final userId = await getUserId();
    if (userId == null) {
      print('❌ Cannot set timezone: User ID not found');
      return;
    }

    final prefs = await SharedPreferences.getInstance();
    await prefs.setString(_keyTimezone(userId), timezone);
    print('⏰ Set timezone for user $userId: $timezone');
  }

  static Future<String> getTimezone() async {
    final userId = await getUserId();
    if (userId == null) {
      print('⚠️ User ID not found, using default timezone');
      return DEFAULT_TIMEZONE;
    }

    final prefs = await SharedPreferences.getInstance();
    final timezone = prefs.getString(_keyTimezone(userId));

    if (timezone == null || timezone.isEmpty) {
      await prefs.setString(_keyTimezone(userId), DEFAULT_TIMEZONE);
      print('⏰ Using default timezone for user $userId: $DEFAULT_TIMEZONE');
      return DEFAULT_TIMEZONE;
    }

    print('⏰ Get timezone for user $userId: $timezone');
    return timezone;
  }

  static Future<void> setPreferences({
    String? currency,
    String? timezone,
  }) async {
    if (currency != null) await setCurrency(currency);
    if (timezone != null) await setTimezone(timezone);
  }

  static Future<void> initializeDefaults() async {
    final userId = await getUserId();
    if (userId == null) {
      print('⚠️ Cannot initialize: User ID not found');
      return;
    }

    final prefs = await SharedPreferences.getInstance();
    final currencyKey = _keyCurrency(userId);
    final timezoneKey = _keyTimezone(userId);

    if (!prefs.containsKey(currencyKey)) {
      await prefs.setString(currencyKey, DEFAULT_CURRENCY);
      print(
          '✅ Initialized default currency for user $userId: $DEFAULT_CURRENCY');
    }

    if (!prefs.containsKey(timezoneKey)) {
      await prefs.setString(timezoneKey, DEFAULT_TIMEZONE);
      print(
          '✅ Initialized default timezone for user $userId: $DEFAULT_TIMEZONE');
    }
  }

  static Future<void> clearAll() async {
    final userId = await getUserId();
    if (userId == null) return;

    final prefs = await SharedPreferences.getInstance();
    await prefs.remove(_keyCurrency(userId));
    await prefs.remove(_keyTimezone(userId));
    print('🗑️ Cleared preferences for user $userId');
  }

  static Future<void> resetToDefaults() async {
    final userId = await getUserId();
    if (userId == null) return;

    final prefs = await SharedPreferences.getInstance();
    await prefs.setString(_keyCurrency(userId), DEFAULT_CURRENCY);
    await prefs.setString(_keyTimezone(userId), DEFAULT_TIMEZONE);
    print(
        '🔄 Reset to defaults for user $userId: $DEFAULT_CURRENCY, $DEFAULT_TIMEZONE');
  }
}
