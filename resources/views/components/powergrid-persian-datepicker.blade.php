<div>
    @json($attributes->getAttributes())
    <x-persian-datepicker
    wirePropertyName="filters.input_text.updated_at"
    {{ $attributes->get('inputAttributes') }}
    showFormat="jYYYY/jMM/jDD"
    returnFormat="YYYY-MM-DD"
    :required="false"
    :defaultDate="date('Y/m/d')"
    :setNullInput="true"
    :withTime="false"
    :ignoreWire="true"
    :withTimeSeconds="true"/>
</div>
