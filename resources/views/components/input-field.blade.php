<div class="mt-4 flex flex-col">
  <label for="{{ $id }}" class="mb-2 font-normal text-gray-800">
    {{ $level }}
    @if ($required && $required === true)
      <span class="text-md text-red-500">*</span> <!-- Red asterisk for required field -->
    @endif
  </label>

  @if ($type === 'select')
    <!-- Render select field -->
    <select id="{{ $id }}" name="{{ $name }}"
      class="{{ $disabled || $readonly ? 'bg-gray-200' : '' }} h-[3rem] rounded-lg border !border-[#6E829F] p-2 !text-gray-800"
      {{ $disabled ? 'disabled' : '' }} {{ $required && $required === true ? 'required' : '' }}>
      <!-- Conditionally required -->
      <option value="" disabled {{ old($name, $value) === null ? 'selected' : '' }}>
        {{ $placeholder }}
      </option>
      @foreach ($valueList as $key => $displayValue)
        <option value="{{ $key }}" {{ old($name, $value) == $key ? 'selected' : '' }}>
          {{ $displayValue }}
        </option>
      @endforeach
    </select>
  @elseif ($type === 'money')
    <input type="text" id="{{ $id }}_formatted"
      class="{{ $disabled || $readonly ? 'bg-[#EBEBEB]' : '' }} {{ $rightAlign && $rightAlign === true ? 'text-right' : 'text-left' }} h-[3rem] w-full rounded-lg border !border-[#6E829F] p-2 !text-gray-800"
      placeholder="{{ $placeholder }}"
      value="{{ old($name, $value) !== null && old($name, $value) !== '' && old($name, $value) !== '0' ? number_format(old($name, $value), 0, '.', ',') : '' }}"
      {{ $readonly ? 'readonly' : '' }} {{ $disabled ? 'disabled' : '' }}>

    <input type="hidden" name="{{ $name }}" id="{{ $id }}" value="{{ old($name, $value) }}">
  @else
    <!-- Render input field -->
    <input type="{{ $type }}" id="{{ $id }}" name="{{ $name }}"
      class="{{ $disabled || $readonly ? 'bg-[#EBEBEB]' : '' }} {{ $rightAlign && $rightAlign === true ? 'text-right' : 'text-left' }} h-[3rem] w-full rounded-lg border !border-[#6E829F] p-2 !text-gray-800"
      placeholder="{{ $placeholder }}" value="{{ old($name, $value) }}" {{ $readonly ? 'readonly' : '' }}
      {{ $disabled ? 'disabled' : '' }} {{ $required && $required === true ? 'required' : '' }}>

    <!-- Conditionally required -->
  @endif

  @if (!empty($spanText))
    <span class="mb-4 font-normal text-gray-500">({{ $spanText }})</span>
  @endif

  <!-- Show error message if validation fails -->
  @if ($errors->has($name))
    <span class="mt-1 text-sm text-red-500">{{ $errors->first($name) }}</span>
  @endif
</div>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const formattedInput = document.getElementById('{{ $id }}_formatted');
    const hiddenInput = document.getElementById('{{ $id }}');

    if (formattedInput && hiddenInput) {
      formattedInput.addEventListener('input', function() {
        let raw = this.value.replace(/,/g, '');
        if (!isNaN(raw)) {
          hiddenInput.value = raw;
          this.value = raw ? Number(raw).toLocaleString('en-US') : '';
        } else {
          this.value = '';
          hiddenInput.value = '';
        }
      });

      // Initial formatting in case of back navigation or autofill
      if (hiddenInput.value && hiddenInput.value !== '0') {
        formattedInput.value = Number(hiddenInput.value).toLocaleString('en-US');
      } else {
        formattedInput.value = '';
      }
    }
  });
</script>
