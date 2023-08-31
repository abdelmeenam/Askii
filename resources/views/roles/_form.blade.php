<form action="{{ $action }}" method="post">
    @csrf
    @if($method == 'PUT')
        @method('PUT')
    @endif

    <div class="form-group mb-3">
        <label for="name" class="form-label">Role Name</label>
        <div class="mt-3">
            <input type="text" value="{{ old('name' , $role->name) }}"  class="form-control @error('name') is-invalid @enderror " id="name" name="name" required>
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>


        <div class="mt-3">
            @foreach(config('abilities') as $code => $label)
              <div class="form-check">
                  <input class="form-check-input" type="checkbox"  name="abilities[]" value="{{$code}}" @checked(in_array($code ,$role->abilities ?? [] ))>
                  <label class="form-check-label">
                        {{ $label }}
                    </label>
                </div>
            @endforeach
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
</form>
