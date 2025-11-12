class ApiConstants {
  // Base URL for API
  static const String baseUrl = 'https://api.example.com';
  
  // API Endpoints
  static const String login = '/auth/login';
  static const String register = '/auth/register';
  
  // Timeouts
  static const int connectionTimeout = 30000; // 30 seconds
  static const int receiveTimeout = 30000; // 30 seconds
  
  // Headers
  static const String contentType = 'application/json';
  static const String accept = 'application/json';
}
