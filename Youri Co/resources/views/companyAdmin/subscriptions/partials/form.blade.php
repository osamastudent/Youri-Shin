<div class="mb-3">
    <label>Title</label>
    <input type="text" name="title"
        class="form-control"
        value="{{ old('title',$subscription->title ?? '') }}">
</div>

<div class="mb-3">
    <label>Type</label>
    <select name="type" class="form-control">
        @foreach(['daily','weekly','monthly'] as $type)
            <option value="{{ $type }}"
                {{ (old('type',$subscription->type ?? '')==$type) ? 'selected':'' }}>
                {{ ucfirst($type) }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Price</label>
    <input type="number" name="price"
        class="form-control"
        value="{{ old('price',$subscription->price ?? '') }}">
</div>

<div class="mb-3">
    <label>Duration</label>
    <input type="number" name="duration"
        class="form-control"
        value="{{ old('duration',$subscription->duration ?? '') }}">
</div>
