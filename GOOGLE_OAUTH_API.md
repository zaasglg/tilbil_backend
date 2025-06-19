# Google OAuth API Documentation for Flutter

This API provides Google OAuth authentication for the Tilbil Kazakh learning application.

## Setup

### 1. Google Developer Console Setup
1. Go to [Google Developer Console](https://console.developers.google.com/)
2. Create a new project or select existing one
3. Enable Google+ API and Google Identity API
4. Create OAuth 2.0 credentials:
   - For Android: Add your app's SHA-1 fingerprint
   - For iOS: Add your app's bundle identifier
   - For Web: Add your domain

### 2. Flutter Setup
Add to your `pubspec.yaml`:
```yaml
dependencies:
  google_sign_in: ^6.1.5
  http: ^1.1.0
```

### 3. Android Setup
Add to `android/app/build.gradle`:
```gradle
android {
    defaultConfig {
        // Add this line
        manifestPlaceholders = [hostName:"your-domain.com"]
    }
}
```

### 4. iOS Setup
Add to `ios/Runner/Info.plist`:
```xml
<key>CFBundleURLTypes</key>
<array>
    <dict>
        <key>CFBundleURLName</key>
        <string>REVERSED_CLIENT_ID</string>
        <key>CFBundleURLSchemes</key>
        <array>
            <string>YOUR_REVERSED_CLIENT_ID</string>
        </array>
    </dict>
</array>
```

## API Endpoints

### Base URL
```
http://127.0.0.1:8000/api
```

## Authentication Methods

### Method 1: Access Token (Recommended for simple integration)

**Endpoint:** `POST /auth/google`

**Request Body:**
```json
{
    "access_token": "ya29.a0AfH6SMB..."
}
```

**Response (Success):**
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

### Method 2: ID Token (More secure, recommended for production)

**Endpoint:** `POST /auth/google/id-token`

**Request Body:**
```json
{
    "id_token": "eyJhbGciOiJSUzI1NiIs..."
}
```

**Response:** Same as Method 1

### Unlink Google Account

**Endpoint:** `POST /auth/google/unlink`

**Headers:**
```
Authorization: Bearer {token}
```

**Response (Success):**
```json
{
    "success": true,
    "message": "Google account unlinked successfully"
}
```

## Flutter Implementation Example

### 1. Setup Google Sign In

```dart
import 'package:google_sign_in/google_sign_in.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

class AuthService {
  static const String baseUrl = 'http://127.0.0.1:8000/api';
  
  final GoogleSignIn _googleSignIn = GoogleSignIn(
    scopes: ['email', 'profile'],
  );

  // Method 1: Using Access Token (Recommended for simplicity)
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
      if (data['success']) {
        // Save token to secure storage
        await saveToken(data['data']['token']);
        return data['data'];
      }
      return null;
    } catch (e) {
      print('Google Sign In Error: $e');
      return null;
    }
  }

  // Method 2: Using ID Token (More secure, recommended for production)
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
      if (data['success']) {
        // Save token to secure storage
        await saveToken(data['data']['token']);
        return data['data'];
      }
      return null;
    } catch (e) {
      print('Google Sign In Error: $e');
      return null;
    }
  }

  Future<void> saveToken(String token) async {
    // Save to secure storage (use flutter_secure_storage package)
    // await secureStorage.write(key: 'auth_token', value: token);
  }

  Future<String?> getToken() async {
    // Get from secure storage
    // return await secureStorage.read(key: 'auth_token');
    return null;
  }

  Future<bool> unlinkGoogle() async {
    try {
      final token = await getToken();
      if (token == null) return false;

      final response = await http.post(
        Uri.parse('$baseUrl/auth/google/unlink'),
        headers: {
          'Content-Type': 'application/json',
          'Authorization': 'Bearer $token',
        },
      );

      final data = jsonDecode(response.body);
      return data['success'];
    } catch (e) {
      print('Unlink Google Error: $e');
      return false;
    }
  }

  Future<void> signOut() async {
    await _googleSignIn.signOut();
    // Clear saved token
    // await secureStorage.delete(key: 'auth_token');
  }
}
```

### 2. Usage in Widget

```dart
class LoginPage extends StatefulWidget {
  @override
  _LoginPageState createState() => _LoginPageState();
}

class _LoginPageState extends State<LoginPage> {
  final AuthService _authService = AuthService();
  bool _isLoading = false;

  Future<void> _handleGoogleSignIn() async {
    setState(() => _isLoading = true);
    
    final result = await _authService.signInWithGoogleIdToken();
    
    setState(() => _isLoading = false);
    
    if (result != null) {
      // Navigate to home page
      Navigator.pushReplacementNamed(context, '/home');
    } else {
      // Show error message
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('Google sign in failed')),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Center(
        child: _isLoading
            ? CircularProgressIndicator()
            : ElevatedButton.icon(
                onPressed: _handleGoogleSignIn,
                icon: Icon(Icons.login),
                label: Text('Sign in with Google'),
              ),
      ),
    );
  }
}
```

## Error Responses

**Invalid Token (401):**
```json
{
    "success": false,
    "message": "Invalid Google access token"
}
```

**Server Error (500):**
```json
{
    "success": false,
    "message": "Google authentication failed",
    "error": "Error details..."
}
```

## Security Notes

1. **ID Token vs Access Token**: ID tokens are more secure for authentication as they contain user identity information and can be verified server-side.

2. **Token Storage**: Always store API tokens securely using `flutter_secure_storage` package.

3. **HTTPS**: In production, always use HTTPS for all API calls.

4. **Token Expiration**: Implement token refresh logic in your app.

## Configuration

Update your `.env` file with actual Google OAuth credentials:

```env
GOOGLE_CLIENT_ID=your_actual_google_client_id.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=your_actual_google_client_secret
GOOGLE_REDIRECT_URI=http://127.0.0.1:8000/api/auth/google/callback
```

## Additional Features

The API also supports:
- Linking Google account to existing email-based accounts
- Unlinking Google accounts (requires password to be set)
- Updating user profile information from Google

## Support

For issues or questions, refer to:
- [Google Sign-In Flutter Plugin](https://pub.dev/packages/google_sign_in)
- [Google OAuth 2.0 Documentation](https://developers.google.com/identity/protocols/oauth2)
