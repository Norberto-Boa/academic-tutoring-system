<div class="col-12 col-md-8">
  <div>
    <h2>Update Passowrd</h2>
    <p class="mt-2">Ensure yout acount is using a long, random password to stay secure.</p>
  </div>

  <form action="{{ route("password.update") }}" method="POST">
    @csrf
    @method("put")

    <div class="form-group">
      <label for="current_password">Current Password</label>
      <input type="password" class="form-control" name="current_password" id="current_password"
        placeholder="Write your current password">
    </div>

    <div class="form-group">
      <label for="password">New Password</label>
      <input type="password" class="form-control" name="password" id="password" placeholder="Write your new password">
    </div>

    <div class="form-group">
      <label for="confirm_passowrd">Confirm New Password</label>
      <input type="password" class="form-control" name="password_confirmation" id="confirm_passowrd"
        placeholder="Confirm the new password">
    </div>

    @error("password")
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
    @enderror

    <button type="submit" class="btn btn-primary">Submit</button>

    @if (session("success"))
      <div class="alert alert-success text-center font-bold">
        {{ session("success") }}
      </div>
    @endif
  </form>
</div>
