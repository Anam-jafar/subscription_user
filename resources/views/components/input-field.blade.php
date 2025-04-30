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
    value="{{ old($name, $value) !== null && old($name, $value) !== '' && old($name, $value) !== '0' ? number_format((float) old($name, $value), 2, '.', ',') : '' }}"
    {{ $readonly ? 'readonly' : '' }} {{ $disabled ? 'disabled' : '' }}>

  <input type="hidden" name="{{ $name }}" id="{{ $id }}" value="{{ old($name, $value) !== null && old($name, $value) !== '' ? number_format((float) old($name, $value), 2, '.', '') : '' }}">

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
document.addEventListener('DOMContentLoaded', function () {
  const formattedInput = document.getElementById('{{ $id }}_formatted');
  const hiddenInput = document.getElementById('{{ $id }}');

  if (formattedInput && hiddenInput) {
    formattedInput.addEventListener('input', function () {
      let raw = this.value.replace(/,/g, '').replace(/[^0-9.]/g, '');

      // Only allow one decimal point
      const parts = raw.split('.');
      if (parts.length > 2) {
        raw = parts[0] + '.' + parts.slice(1).join('');
      }

      // Limit decimal to 2 places
      if (parts.length === 2) {
        raw = parts[0] + '.' + parts[1].slice(0, 2);
      }

      hiddenInput.value = raw;
    });

    // Format on blur (when input loses focus)
    formattedInput.addEventListener('blur', function () {
      const raw = hiddenInput.value;
      const floatVal = parseFloat(raw);
      if (!isNaN(floatVal)) {
        formattedInput.value = floatVal.toLocaleString('en-US', {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2
        });
        hiddenInput.value = floatVal.toFixed(2);
      } else {
        formattedInput.value = '';
        hiddenInput.value = '';
      }
    });

    // Initial formatting on load (e.g., browser back, autofill)
    if (hiddenInput.value && hiddenInput.value !== '0') {
      const floatVal = parseFloat(hiddenInput.value);
      if (!isNaN(floatVal)) {
        formattedInput.value = floatVal.toLocaleString('en-US', {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2
        });
      }
    } else {
      formattedInput.value = '';
    }
  }
});


</script>
