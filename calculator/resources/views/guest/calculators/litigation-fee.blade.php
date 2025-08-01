@extends('layout.app')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center mb-4">Polgári peres illetékkalkulátor</h1>
        <div class="row">
            <!-- Bal oldal: űrlap -->
            <div class="col-12 col-md-8">
                <form id="litigation-fee-form">
                    <!-- Eljárás típusa -->
                    <div class="mb-3">
                        <label for="procedureType" class="form-label">Eljárás típusa</label>
                        <select id="procedureType" name="procedure_type" class="form-select">
                            <option value="" selected disabled>Válasz a listából</option>

                            @foreach ($settings['procedure_types']->setting_value as $procedure_type)
                                <option value="{{ $procedure_type['key'] }}">{{ $procedure_type['label'] }}</option>
                            @endforeach

                        </select>
                    </div>

                    <!-- Bíróság szintje -->
                    <div class="mb-3">
                        <label class="form-label d-block">Bíróság szintje</label>
                        @foreach ($settings['court_levels']->setting_value as $court_level)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="court_level"
                                    id="court-level{{ $loop->iteration }}" value="{{ $court_level['key'] }}">
                                <label class="form-check-label"
                                    for="court-level{{ $loop->iteration }}">{{ $court_level['label'] }}</label>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pertárgy értéke -->
                    <div class="mb-3">
                        <label for="value" class="form-label">Pertárgy értéke</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="value" name="amount" step="0.01"
                                placeholder="Írd be az összeget">
                            <span class="input-group-text">Ft</span>
                        </div>
                        <div class="form-check mt-2">
                            <input type="hidden" name="indefinable" value="0">
                            <input type="checkbox" class="form-check-input" id="indefinable" name="indefinable"
                                value="1">
                            <label class="form-check-label" for="indefinable">Meghatározhatatlan érték</label>
                        </div>
                    </div>

                    <!-- Opciók -->
                    <div class="mb-3">
                        <label class="form-label d-block">További opciók</label>
                        @foreach ($settings['additional_options']->setting_value as $additional_option)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"
                                    id="additional-option-{{ $additional_option['key'] }}"
                                    name="{{ $additional_option['key'] }}" value="1">
                                <label class="form-check-label"
                                    for="additional-option-{{ $additional_option['key'] }}">{{ $additional_option['label'] }}</label>
                            </div>
                        @endforeach
                    </div>

                    <div class="mb-3">
                        <label for="special-type" class="form-label">Különleges illeték típus</label>
                        <select name="special_type" id="special-type" class="form-select">
                            <option value="" selected disabled>Válasz a listából</option>
                            @foreach ($settings['special_case_types']->setting_value as $special_case_type)
                                <option value="{{ $special_case_type['key'] }}">{{ $special_case_type['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
                <!-- TÖRVÉNYI HIVATKOZÁSOK KIEGÉSZITÉS-->
                <div class="mt-auto pt-3 border-top">
                    <div class="mt-2">
                        <span class="text-muted small">
                            * Illetéktörvény: 1990. évi XCIII. törvény (különösen 39–42. §)
                        </span>
                    </div>
                    <div class="mt-2">
                        <span class="text-muted small">
                            * Polgári perrendtartás: 2016. évi CXXX. törvény (Pp.)
                        </span>
                    </div>
                </div>
            </div>
            <!-- Jobb oldal: Illetékszámítás -->
            <div class="col-12 col-md-4 d-flex justify-content-center align-items-center">
                <div class="border rounded p-2 w-100 d-grid" style="grid-template-rows: auto 1fr auto; min-height: 350px;">
                    <h5 class="mt-4">Illetékszámítás</h5>

                    <div class="d-flex flex-column justify-content-start">
                        <div class="d-flex mt-5 justify-content-between">
                            <span>Alap</span>
                            <span id="fee-base">0 Ft</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Kedvezmények</span>
                            <span id="fee-discount">0 Ft</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Előzetes bizonyítás kedvezmény</span>
                            <span id="fee-pre-evidence-discount">0 Ft</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Különleges illeték</span>
                            <span id="fee-special">0 Ft</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold">
                            <span>Összesen</span>
                            <span id="fee-total">0 Ft</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Szükséges elemek
        const form = document.getElementById('litigation-fee-form');
        const amountInput = document.getElementById('value');
        const procedureTypeSelect = document.getElementById('procedureType');
        const courtLevelRadios = document.querySelectorAll('input[name="court_level"]');
        const indefinableCheckbox = document.getElementById('indefinable');
        const feeBase = document.getElementById('fee-base');
        const feeTotal = document.getElementById('fee-total');
        const feeDiscount = document.getElementById('fee-discount');
        const feePreEvidenceDiscount = document.getElementById('fee-pre-evidence-discount');
        const feeSpecial = document.getElementById('fee-special');
        const specialTypeSelect = document.getElementById('special-type');
        const fmhCheckbox = document.getElementById('additional-option-fmh');

        function getSelectedCourtLevel() {
            let courtLevel = null;
            courtLevelRadios.forEach(radio => {
                if (radio.checked) courtLevel = radio.value;
            });
            return courtLevel;
        }

        function sendFeeAjax() {
            const formData = new FormData(form);
            const procedureType = procedureTypeSelect.value;
            const courtLevel = getSelectedCourtLevel();

            if (!procedureType || !courtLevel) {
                feeBase.textContent = '0 Ft';
                feeTotal.textContent = '';
                feeDiscount.textContent = '0 Ft';
                feePreEvidenceDiscount.textContent = '0 Ft';
                feeSpecial.textContent = '0 Ft';
                return;
            }

            axios.get("{{ route('litigation-fee.process') }}", formData, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    }
                })
                .then(response => {
                    const data = response.data;

                    feeBase.textContent = (data.baseFee ? data.baseFee + ' Ft' : '0 Ft');

                    let total = data.baseFee ? data.baseFee : 0;

                    if (data.specialFee) {
                        total -= data.specialFee;
                    }

                    feeTotal.textContent = total + ' Ft';
                    feeDiscount.textContent = (data.discount && data.discount > 0) ? '-' + data.discount + ' Ft' :
                        '0 Ft';
                    feePreEvidenceDiscount.textContent = (data.preEvidenceDiscount ? '-' + data.preEvidenceDiscount +
                        ' Ft' : '0 Ft');
                    feeSpecial.textContent = (data.specialFee ? data.specialFee + ' Ft' : '0 Ft');
                })
                .catch(error => {
                    alert('Hiba történt: ' + (error.response?.data?.message || error));
                    console.error(error);
                });
        }
// TODO: CHECKOLNI!!! HIBÁS!!!
        function setHelpBaseFeeIfNeeded() {
            const procedureType = procedureTypeSelect.value;
            const courtLevel = getSelectedCourtLevel();
            const indefinable = indefinableCheckbox.checked;
            if (indefinable && procedureType && courtLevel) {
                amountInput.disabled = true;
            } else {
                amountInput.disabled = false;
            }
            sendFeeAjax();
        }

        function toggleAmountDisabled() {
            if (indefinableCheckbox.checked) {
                amountInput.disabled = true;
                amountInput.value = '';
            } else {
                amountInput.disabled = false;
            }
            sendFeeAjax();
        }

        document.addEventListener('DOMContentLoaded', function() {
            form.querySelectorAll('input, select').forEach(function(el) {
                el.addEventListener('input', sendFeeAjax);
                el.addEventListener('change', sendFeeAjax);
            });

            procedureTypeSelect.addEventListener('change', setHelpBaseFeeIfNeeded);

            courtLevelRadios.forEach(radio => {
                radio.addEventListener('change', setHelpBaseFeeIfNeeded);
            });

            indefinableCheckbox.addEventListener('change', toggleAmountDisabled);

            fmhCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    specialTypeSelect.value = 'opposition_to_payment_order';
                    specialTypeSelect.dispatchEvent(new Event('change'));
                }
            });
            setHelpBaseFeeIfNeeded();
            toggleAmountDisabled();
        });
    </script>
@endsection
