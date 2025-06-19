# Test Google OAuth API

## Test with curl

### Test invalid access token
```bash
curl -X POST http://127.0.0.1:8000/api/auth/google \
  -H "Content-Type: application/json" \
  -d '{"access_token": "invalid_token"}'
```

### Test invalid ID token
```bash
curl -X POST http://127.0.0.1:8000/api/auth/google/id-token \
  -H "Content-Type: application/json" \
  -d '{"id_token": "invalid_token"}'
```

### Test routes availability
```bash
curl -X GET http://127.0.0.1:8000/api/levels
```

## Flutter Integration Example

```dart
import 'package:google_sign_in/google_sign_in.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

class AuthService {
  static const String baseUrl = 'http://127.0.0.1:8000/api';
  
  final GoogleSignIn _googleSignIn = GoogleSignIn(
    scopes: ['email', 'profile'],
  );

  // Method 1: Using Access Token (Simpler)
  Future<Map<String, dynamic>?> signInWithGoogleAccessToken() async {
    try {
      final GoogleSignInAccount? googleUser = await _googleSignIn.signIn();
      if (googleUser == null) return null;

      final GoogleSignInAuthentication googleAuth = await googleUser.authentication;
      
      final response = await http.post(
        Uri.parse('$baseUrl/auth/google'),
        headers: {'Content-Type': 'application/json'},
        body: jsonEncode({
          'access_token': googleAuth.accessToken,
        }),
      );

      final data = jsonDecode(response.body);
      print('Response: $data');
      
      if (data['success']) {
        return data['data'];
      }
      return null;
    } catch (e) {
      print('Google Sign In Error: $e');
      return null;
    }
  }

  // Method 2: Using ID Token (More secure)
  Future<Map<String, dynamic>?> signInWithGoogleIdToken() async {
    try {
      final GoogleSignInAccount? googleUser = await _googleSignIn.signIn();
      if (googleUser == null) return null;

      final GoogleSignInAuthentication googleAuth = await googleUser.authentication;
      
      final response = await http.post(
        Uri.parse('$baseUrl/auth/google/id-token'),
        headers: {'Content-Type': 'application/json'},
        body: jsonEncode({
          'id_token': googleAuth.idToken,
        }),
      );

      final data = jsonDecode(response.body);
      print('Response: $data');
      
      if (data['success']) {
        return data['data'];
      }
      return null;
    } catch (e) {
      print('Google Sign In Error: $e');
      return null;
    }
  }
}
```

## Expected Responses

### Success Response
```json
{
  "success": true,
  "message": "Google authentication successful",
  "data": {
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "google_id": "123456789",
      "avatar_url": "https://lh3.googleusercontent.com/...",
      "email_verified_at": "2025-06-19T09:54:21.000000Z",
      "created_at": "2025-06-19T09:54:21.000000Z",
      "updated_at": "2025-06-19T09:54:21.000000Z"
    },
    "token": "1|abcdef123456..."
  }
}
```

### Error Response
```json
{
  "success": false,
  "message": "Invalid Google access token"
}
```
