@isset ($errors)
    @error($name)
        <span role="alert" class="invalid-feedback">{{ $message }}</span>
    @enderror
@endisset
