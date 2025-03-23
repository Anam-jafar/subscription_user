<div class="flex flex-col mt-4">
    <label for="{{ $id }}" class="text-gray-800 font-normal mb-2">
        {{ $level }}
        @if ($required && $required === true)
            <span class="text-md text-red-500">*</span> <!-- Red asterisk for required field -->
        @endif
    </label>

    @if ($type === 'select')
        <!-- Render select field -->
        <select id="{{ $id }}" name="{{ $name }}"
            class="p-2 border !border-[#6E829F] rounded-lg !text-gray-800 h-[3rem]
                {{ $disabled || $readonly ? 'bg-gray-200' : '' }}"
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
    @else
        <!-- Render input field -->
        <input type="{{ $type }}" id="{{ $id }}" name="{{ $name }}"
            class="p-2 border !border-[#6E829F] rounded-lg !text-gray-800 h-[3rem]
                {{ $disabled || $readonly ? 'bg-[#EBEBEB]' : '' }} 
                {{ $rightAlign && $rightAlign === true ? 'text-right' : 'text-left' }}"
            placeholder="{{ $placeholder }}" value="{{ old($name, $value) }}" {{ $readonly ? 'readonly' : '' }}
            {{ $disabled ? 'disabled' : '' }} {{ $required && $required === true ? 'required' : '' }}>
        <!-- Conditionally required -->
    @endif

    @if (!empty($spanText))
        <span class="text-gray-500 font-normal mb-4">({{ $spanText }})</span>
    @endif

    <!-- Show error message if validation fails -->
    @if ($errors->has($name))
        <span class="text-red-500 text-sm mt-1">{{ $errors->first($name) }}</span>
    @endif
</div>
