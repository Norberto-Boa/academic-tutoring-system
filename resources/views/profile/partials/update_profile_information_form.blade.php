<div class="col-12 col-md-8">
  <div>
    <h2>Update Profile Information</h2>
    <p class="mt-2">Update your account's profile information</p>
  </div>

  <form action="{{ route("profile.update") }}" method="POST">
    @csrf
    @method("put")

    <div class="form-group">
      <label for="name">Name</label>
      <input type="text" class="form-control" name="name" id="name" placeholder="Write your new name">
    </div>

    {{-- Email Input --}}
    {{-- <div class="form-group">
      <label for="password">Email</label>
      <input type="password" class="form-control" name="password" id="password" placeholder="Write your new Email">
    </div> --}}

    @error("password")
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
    @enderror

    <button type="submit" class="btn btn-primary">Submit</button>

    @if (session("success"))
      <div class="alert alert-success text-center font-bold mt-2">
        {{ session("success") }}
      </div>
    @endif
  </form>
</div>
