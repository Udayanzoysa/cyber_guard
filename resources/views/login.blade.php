<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Form</title>
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('css/main.css') }}" rel="stylesheet">
  <style>
    * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Arial', sans-serif;
  background-image:linear-gradient(15deg, #13547a 0%, #80d0c7 100%);
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.container {
  display: flex;
  justify-content: center;
  align-items: center;
}

.login-box {
  background-color: #fff;
  padding: 30px;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  width: 400px;
  max-width: 100%;
}

h2 {
  text-align: center;
  margin-bottom: 20px;
  color: #333;
}

.input-group {
  margin-bottom: 20px;
}

.input-group label {
  font-size: 14px;
  color: #666;
}

.input-group input {
  width: 100%;
  padding: 12px;
  border: 1px solid #ddd;
  border-radius: 5px;
  margin-top: 5px;
  font-size: 14px;
}

.input-group input:focus {
  border-color: #3498db;
  outline: none;
}

.error-message {
  color: red;
  font-size: 12px;
  margin-top: 5px;
}

.submit-btn {
  width: 100%;
  padding: 12px;
  background-color: #3498db;
  border: none;
  color: white;
  font-size: 16px;
  cursor: pointer;
  border-radius: 5px;
}

.submit-btn:hover {
  background-color: #2980b9;
}

.forgot-password {
  text-align: center;
  margin-top: 10px;
}

.forgot-password a {
  color: #3498db;
  text-decoration: none;
}

.forgot-password a:hover {
  text-decoration: underline;
}

.signup-link {
  text-align: center;
  margin-top: 15px;
}

.signup-link a {
  color: #3498db;
  text-decoration: none;
}

.signup-link a:hover {
  text-decoration: underline;
}

@media (max-width: 480px) {
  .login-box {
    padding: 20px;
  }
}

  </style>
</head>
<body>

  <div class="container">
    <div class="login-box">
      <h2>Login</h2>
      <form method="post" action="{{route('login.action')}}">
        @csrf
        @if(session('error'))
            <span class="alert alert-danger mb-1 row">{{session('error')}}</span>
        @endif
        <div class="input-group">
          <label for="email">Username</label>
          <input type="text" name="user"  id="exampleInputEmail1" placeholder="Enter your email" required>
          <small id="email-error" class="error-message"></small>
        </div>

        <div class="input-group">
          <label for="password">Password</label>
          <input type="password" name="pass" id="exampleInputPassword1" placeholder="Enter your password" required>
          <small id="password-error" class="error-message"></small>
        </div>

        <button type="submit" class="submit-btn">Login</button>
      </form>

      <p class="signup-link">Don't have an account? <a href="/register">Sign up here</a></p>
    </div>
  </div>

</body>
</html>
