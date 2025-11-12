abstract class NetworkInfo {
  Future<bool> get isConnected;
}

// You can implement this with connectivity_plus package if needed
// For now, we'll create a basic implementation
class NetworkInfoImpl implements NetworkInfo {
  @override
  Future<bool> get isConnected async {
    // TODO: Implement with connectivity_plus package
    // For now, return true
    return true;
  }
}
