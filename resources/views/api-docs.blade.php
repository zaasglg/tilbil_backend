<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tilbil API Documentation</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/themes/prism.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/components/prism-core.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/plugins/autoloader/prism-autoloader.min.js"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-6">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Tilbil API Documentation</h1>
                        <p class="text-gray-600 mt-1">Language Learning Platform API</p>
                    </div>
                    <div class="text-sm text-gray-500">
                        Base URL: <code class="bg-gray-100 px-2 py-1 rounded">{{ url('/api') }}</code>
                    </div>
                </div>
            </div>
        </header>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Sidebar Navigation -->
                <div class="lg:col-span-1">
                    <nav class="sticky top-8">
                        <div class="bg-white rounded-lg shadow p-6">
                            <h3 class="font-semibold text-gray-900 mb-4">Navigation</h3>
                            <ul class="space-y-2 text-sm">
                                <li><a href="#authentication" class="text-blue-600 hover:text-blue-800">Authentication</a></li>
                                <li><a href="#levels" class="text-blue-600 hover:text-blue-800">Levels</a></li>
                                <li><a href="#courses" class="text-blue-600 hover:text-blue-800">Courses</a></li>
                                <li><a href="#lessons" class="text-blue-600 hover:text-blue-800">Lessons</a></li>
                                <li><a href="#vocabulary" class="text-blue-600 hover:text-blue-800">Vocabulary</a></li>
                                <li><a href="#quizzes" class="text-blue-600 hover:text-blue-800">Quizzes</a></li>
                                <li><a href="#progress" class="text-blue-600 hover:text-blue-800">User Progress</a></li>
                                <li><a href="#achievements" class="text-blue-600 hover:text-blue-800">Achievements</a></li>
                            </ul>
                        </div>
                    </nav>
                </div>

                <!-- Main Content -->
                <div class="lg:col-span-3">
                    <!-- Authentication Section -->
                    <section id="authentication" class="mb-12">
                        <div class="bg-white rounded-lg shadow p-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">Authentication</h2>
                            <p class="text-gray-600 mb-6">The API uses Laravel Sanctum for authentication. You'll need to obtain a bearer token to access protected endpoints.</p>
                            
                            <!-- Register -->
                            <div class="mb-8">
                                <h3 class="text-lg font-semibold text-gray-800 mb-3">Register</h3>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="flex items-center mb-2">
                                        <span class="bg-green-500 text-white px-2 py-1 rounded text-xs font-medium mr-3">POST</span>
                                        <code>/api/register</code>
                                    </div>
                                    <pre class="text-sm"><code class="language-json">{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123",
  "phone": "+77771234567",
  "birthday": "1990-01-01",
  "surname": "Doe",
  "username": "johndoe",
  "gender": "male"
}</code></pre>
                                </div>
                            </div>

                            <!-- Login -->
                            <div class="mb-8">
                                <h3 class="text-lg font-semibold text-gray-800 mb-3">Login</h3>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="flex items-center mb-2">
                                        <span class="bg-green-500 text-white px-2 py-1 rounded text-xs font-medium mr-3">POST</span>
                                        <code>/api/login</code>
                                    </div>
                                    <pre class="text-sm"><code class="language-json">{
  "email": "john@example.com",
  "password": "password123"
}</code></pre>
                                </div>
                            </div>

                            <!-- Profile Update -->
                            <div class="mb-8">
                                <h3 class="text-lg font-semibold text-gray-800 mb-3">Update Profile</h3>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="flex items-center mb-2">
                                        <span class="bg-yellow-500 text-white px-2 py-1 rounded text-xs font-medium mr-3">POST</span>
                                        <code>/api/profile/update</code>
                                        <span class="ml-3 text-xs text-red-600">🔒 Auth Required</span>
                                    </div>
                                    <pre class="text-sm"><code class="language-json">{
  "name": "John Updated",
  "email": "john.updated@example.com",
  "current_password": "current_password",
  "new_password": "new_password",
  "new_password_confirmation": "new_password"
}</code></pre>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Levels Section -->
                    <section id="levels" class="mb-12">
                        <div class="bg-white rounded-lg shadow p-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">Levels</h2>
                            
                            <div class="space-y-6">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Get All Levels</h3>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="flex items-center mb-2">
                                            <span class="bg-blue-500 text-white px-2 py-1 rounded text-xs font-medium mr-3">GET</span>
                                            <code>/api/levels</code>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Get Level by ID</h3>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="flex items-center mb-2">
                                            <span class="bg-blue-500 text-white px-2 py-1 rounded text-xs font-medium mr-3">GET</span>
                                            <code>/api/levels/{id}</code>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Courses Section -->
                    <section id="courses" class="mb-12">
                        <div class="bg-white rounded-lg shadow p-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">Courses</h2>
                            
                            <div class="space-y-6">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Get All Courses</h3>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="flex items-center mb-2">
                                            <span class="bg-blue-500 text-white px-2 py-1 rounded text-xs font-medium mr-3">GET</span>
                                            <code>/api/courses?level_id={level_id}</code>
                                        </div>
                                        <p class="text-sm text-gray-600 mt-2">Optional query parameter: <code>level_id</code> to filter by level</p>
                                    </div>
                                </div>

                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Get Course by ID</h3>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="flex items-center mb-2">
                                            <span class="bg-blue-500 text-white px-2 py-1 rounded text-xs font-medium mr-3">GET</span>
                                            <code>/api/courses/{id}</code>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Lessons Section -->
                    <section id="lessons" class="mb-12">
                        <div class="bg-white rounded-lg shadow p-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">Lessons</h2>
                            
                            <div class="space-y-6">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Get All Lessons</h3>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="flex items-center mb-2">
                                            <span class="bg-blue-500 text-white px-2 py-1 rounded text-xs font-medium mr-3">GET</span>
                                            <code>/api/lessons?course_id={course_id}</code>
                                        </div>
                                        <p class="text-sm text-gray-600 mt-2">Optional query parameter: <code>course_id</code> to filter by course</p>
                                    </div>
                                </div>

                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Get Lesson by ID</h3>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="flex items-center mb-2">
                                            <span class="bg-blue-500 text-white px-2 py-1 rounded text-xs font-medium mr-3">GET</span>
                                            <code>/api/lessons/{id}</code>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Vocabulary Section -->
                    <section id="vocabulary" class="mb-12">
                        <div class="bg-white rounded-lg shadow p-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">Vocabulary</h2>
                            
                            <div class="space-y-6">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Get All Vocabulary</h3>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="flex items-center mb-2">
                                            <span class="bg-blue-500 text-white px-2 py-1 rounded text-xs font-medium mr-3">GET</span>
                                            <code>/api/vocabulary?lesson_id={lesson_id}</code>
                                        </div>
                                        <p class="text-sm text-gray-600 mt-2">Optional query parameter: <code>lesson_id</code> to filter by lesson</p>
                                    </div>
                                </div>

                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Get Vocabulary by ID</h3>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="flex items-center mb-2">
                                            <span class="bg-blue-500 text-white px-2 py-1 rounded text-xs font-medium mr-3">GET</span>
                                            <code>/api/vocabulary/{id}</code>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Quizzes Section -->
                    <section id="quizzes" class="mb-12">
                        <div class="bg-white rounded-lg shadow p-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">Quizzes</h2>
                            
                            <div class="space-y-6">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Get All Quizzes</h3>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="flex items-center mb-2">
                                            <span class="bg-blue-500 text-white px-2 py-1 rounded text-xs font-medium mr-3">GET</span>
                                            <code>/api/quizzes?lesson_id={lesson_id}</code>
                                        </div>
                                        <p class="text-sm text-gray-600 mt-2">Optional query parameter: <code>lesson_id</code> to filter by lesson</p>
                                    </div>
                                </div>

                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Submit Quiz Answer</h3>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="flex items-center mb-2">
                                            <span class="bg-green-500 text-white px-2 py-1 rounded text-xs font-medium mr-3">POST</span>
                                            <code>/api/quizzes/{id}/submit</code>
                                            <span class="ml-3 text-xs text-red-600">🔒 Auth Required</span>
                                        </div>
                                        <pre class="text-sm"><code class="language-json">{
  "answer": "user_selected_answer"
}</code></pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- User Progress Section -->
                    <section id="progress" class="mb-12">
                        <div class="bg-white rounded-lg shadow p-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">User Progress</h2>
                            <p class="text-gray-600 mb-6">All progress endpoints require authentication.</p>
                            
                            <div class="space-y-6">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Get User Progress</h3>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="flex items-center mb-2">
                                            <span class="bg-blue-500 text-white px-2 py-1 rounded text-xs font-medium mr-3">GET</span>
                                            <code>/api/progress</code>
                                            <span class="ml-3 text-xs text-red-600">🔒 Auth Required</span>
                                        </div>
                                        <p class="text-sm text-gray-600 mt-2">Query parameters: <code>level_id</code>, <code>course_id</code>, <code>status</code></p>
                                    </div>
                                </div>

                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Update Progress</h3>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="flex items-center mb-2">
                                            <span class="bg-green-500 text-white px-2 py-1 rounded text-xs font-medium mr-3">POST</span>
                                            <code>/api/progress</code>
                                            <span class="ml-3 text-xs text-red-600">🔒 Auth Required</span>
                                        </div>
                                        <pre class="text-sm"><code class="language-json">{
  "level_id": 1,
  "course_id": 1,
  "lesson_id": 1,
  "status": "completed",
  "score": 95
}</code></pre>
                                    </div>
                                </div>

                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Get Progress Statistics</h3>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="flex items-center mb-2">
                                            <span class="bg-blue-500 text-white px-2 py-1 rounded text-xs font-medium mr-3">GET</span>
                                            <code>/api/progress/stats</code>
                                            <span class="ml-3 text-xs text-red-600">🔒 Auth Required</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Achievements Section -->
                    <section id="achievements" class="mb-12">
                        <div class="bg-white rounded-lg shadow p-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">Achievements</h2>
                            
                            <div class="space-y-6">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Get All Achievements</h3>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="flex items-center mb-2">
                                            <span class="bg-blue-500 text-white px-2 py-1 rounded text-xs font-medium mr-3">GET</span>
                                            <code>/api/achievements?type={type}</code>
                                        </div>
                                        <p class="text-sm text-gray-600 mt-2">Optional query parameter: <code>type</code> (single, streak, level, quiz_master, dictionary_hero)</p>
                                    </div>
                                </div>

                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Get User Achievements</h3>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="flex items-center mb-2">
                                            <span class="bg-blue-500 text-white px-2 py-1 rounded text-xs font-medium mr-3">GET</span>
                                            <code>/api/user/achievements</code>
                                            <span class="ml-3 text-xs text-red-600">🔒 Auth Required</span>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Award Achievement</h3>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="flex items-center mb-2">
                                            <span class="bg-green-500 text-white px-2 py-1 rounded text-xs font-medium mr-3">POST</span>
                                            <code>/api/achievements/{id}/award</code>
                                            <span class="ml-3 text-xs text-red-600">🔒 Auth Required</span>
                                        </div>
                                        <pre class="text-sm"><code class="language-json">{
  "progress": 100
}</code></pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Response Format Section -->
                    <section id="response-format" class="mb-12">
                        <div class="bg-white rounded-lg shadow p-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">Response Format</h2>
                            
                            <div class="space-y-6">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Success Response</h3>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <pre class="text-sm"><code class="language-json">{
  "success": true,
  "data": {
    // Response data
  },
  "message": "Operation completed successfully" // Optional
}</code></pre>
                                    </div>
                                </div>

                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Error Response</h3>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <pre class="text-sm"><code class="language-json">{
  "success": false,
  "message": "Error description",
  "errors": {
    "field": ["Validation error message"]
  }
}</code></pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Status Codes Section -->
                    <section id="status-codes" class="mb-12">
                        <div class="bg-white rounded-lg shadow p-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">HTTP Status Codes</h2>
                            
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Meaning</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">200</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">OK</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Request successful</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">201</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Created</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Resource created successfully</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">400</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Bad Request</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Invalid request data</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">401</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Unauthorized</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Authentication required</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">403</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Forbidden</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Access denied</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">404</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Not Found</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Resource not found</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">422</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Unprocessable Entity</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Validation errors</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">500</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Internal Server Error</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Server error</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>
