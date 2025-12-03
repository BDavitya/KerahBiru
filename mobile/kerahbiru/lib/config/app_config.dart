class AppConfig {
  static const String API_BASE_URL = "http://10.215.47.243:8000/api";
  static const int SESSION_DURATION_MINUTES = 10;
  static int get sessionDurationSeconds => SESSION_DURATION_MINUTES * 60;
  static String get storageUrl => API_BASE_URL.replaceAll('/api', '/storage');
  static const bool USE_ENCRYPTION = true;
  static const String APP_NAME = "KerahBiru";
  static const String APP_VERSION = "1.0.0";
  static const String APP_DESCRIPTION = "Platform Insan Karya Raga";
}
