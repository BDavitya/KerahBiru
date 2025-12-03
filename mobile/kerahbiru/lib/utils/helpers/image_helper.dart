import '../../config/app_config.dart';
import 'package:flutter/material.dart';

class ImageHelper {
  static String getImageUrl(String? photoPath) {
    if (photoPath == null || photoPath.isEmpty) return '';

    if (photoPath.startsWith('http')) return photoPath;

    final timestamp = DateTime.now().millisecondsSinceEpoch;
    return '${AppConfig.storageUrl}/$photoPath?t=$timestamp';
  }

  static ImageProvider getNetworkImage(
    String? photoPath, {
    String defaultAsset = 'assets/images/user.jpg',
  }) {
    final url = getImageUrl(photoPath);

    if (url.isEmpty) {
      return AssetImage(defaultAsset);
    }

    return NetworkImage(url);
  }

  static Widget buildNetworkImage({
    required String? photoUrl,
    required double width,
    required double height,
    BoxFit fit = BoxFit.cover,
    Widget? placeholder,
    IconData errorIcon = Icons.person,
  }) {
    if (photoUrl == null || photoUrl.isEmpty) {
      return Container(
        width: width,
        height: height,
        color: Colors.grey[300],
        child: Icon(errorIcon, size: height * 0.4, color: Colors.grey),
      );
    }

    return Image.network(
      getImageUrl(photoUrl),
      width: width,
      height: height,
      fit: fit,
      loadingBuilder: (context, child, loadingProgress) {
        if (loadingProgress == null) return child;
        return Container(
          width: width,
          height: height,
          color: Colors.grey[200],
          child: Center(
            child: CircularProgressIndicator(
              value: loadingProgress.expectedTotalBytes != null
                  ? loadingProgress.cumulativeBytesLoaded /
                      loadingProgress.expectedTotalBytes!
                  : null,
              strokeWidth: 2,
              color: const Color(0xFF4A70A9),
            ),
          ),
        );
      },
      errorBuilder: (_, __, ___) => Container(
        width: width,
        height: height,
        color: Colors.grey[300],
        child: Icon(errorIcon, size: height * 0.4, color: Colors.grey),
      ),
    );
  }
}
