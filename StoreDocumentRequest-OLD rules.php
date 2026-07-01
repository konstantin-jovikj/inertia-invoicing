<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    protected function prepareForValidation()
    {
        if ($this->has('vin')) {
            $this->merge([
                'vin' => strtoupper($this->input('vin')),
            ]);
        }

        if (empty($this->datum_na_dokument)) {
            $this->merge([
                'datum_na_dokument' => now()->format('Y-m-d')
            ]);
        }
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // 'user_id' => 'auth()->user.id',
            'doctype' => 'required|exists:doc_types,id',
            'marka' => 'required_if:doctype,1,3',
            'fuel' => 'exists:fuels,id|nullable',
            'tip' => 'required_if:doctype,1,3',
            'varijanta' => 'required_if:doctype,1,3',
            'izvedba' => 'required_if:doctype,1,3',
            'eu_odobrenie' => 'nullable',
            'tip_motor' => 'nullable',
            'cm3' => 'max:50000|integer|nullable|required_if:doctype,1,3',
            'kw' => 'max:20000|integer|nullable|required_if:doctype,1,3',
            'co2_nedc' => [
                'max:500',
                'nullable',
                'integer',
                Rule::when(
                    fn() => in_array($this->input('doctype'), [1, 3]),
                    ['required_without:co2_wltp']
                ),
            ],
            'co2_wltp' => [
                'max:500',
                'nullable',
                'integer',
                Rule::when(
                    fn() => in_array($this->input('doctype'), [1, 3]),
                    ['required_without:co2_nedc']
                ),
            ],
            'file' => [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png,webp',
                'required_if:doctype,1,3',
            ],

            'komercijalna_oznaka' => 'nullable',
            'godina_na_proizvodstvo' => ['nullable', 'digits:4', 'integer', 'min:1900', 'max:' . date('Y')],
            'najgolema_konstruktivna_vkupna_masa' => 'nullable|integer',
            'najgolema_legalna_vkupna_masa' => 'nullable|integer',
            'najgolema_legalna_vkupna_masa_na_grupa_vozila' => 'nullable|integer',
            'masa_na_voziloto' => 'nullable|integer',
            'kategorija_i_vid' => 'nullable',
            'oblik_i_namena' => 'nullable',
            'broj_na_coc' => 'nullable',
            'broj_na_oski' => 'nullable|integer',
            'dolzina' => ['nullable', 'regex:/^\d+(-\d+)?$/'],
            'sirina' => ['nullable', 'regex:/^\d+(-\d+)?$/'],
            'visina' => ['nullable', 'regex:/^\d+(-\d+)?$/'],
            'dozvoleni_pnevmatici_i_naplatki_1' => 'nullable',
            'dozvoleni_pnevmatici_i_naplatki_2' => 'nullable',
            'broj_na_vrtezi' => 'nullable|integer',
            'vin' => ['nullable', 'regex:/^[A-HJ-NPR-Z0-9]{17}$/'],
            'odnos_silina_masa' => 'nullable',
            'boja_na_voziloto' => 'nullable',
            'datum_na_dokument' => 'date|required',
            'stacionarna_bucavost' => 'nullable|integer',
            'brzina_na_vrtenje' => 'nullable|integer',
            'najgolemo_konstr_osno_optovaruvanje_1' => 'nullable|integer',
            'najgolemo_konstr_osno_optovaruvanje_2' => 'nullable|integer',
            'najgolemo_konstr_osno_optovaruvanje_3' => 'nullable|integer',
            'najgolemo_konstr_osno_optovaruvanje_4' => 'nullable|integer',
            'najgolemo_konstr_osno_optovaruvanje_5' => 'nullable|integer',
            'priklucna_tocka' => 'nullable|integer',
            'zagaduvanje' => 'nullable',
            'euro' => 'nullable',
            'additional_doc_1' => 'nullable|file',
            'additional_doc_2' => 'nullable|file',
            'coc_doc' => 'nullable|file',
            'trailer' => 'nullable|integer',
            'unbreaked_trailer' => 'nullable|integer',
            'photo_pdf_1' => 'nullable|file',
            'photo_pdf_2' => 'nullable|file',
            'photo_1' => 'nullable|image',
            'photo_2' => 'nullable|image',

            'izdadena_vo_postapka' => 'nullable',
            'arhivski_broj' => 'nullable | unique:documents,arhivski_broj',
            'najgolema_konstruktivna_vkupna_masa_po_oski_1' => 'nullable|integer',
            'najgolema_konstruktivna_vkupna_masa_po_oski_2' => 'nullable|integer',
            'najgolema_konstruktivna_vkupna_masa_po_oski_3' => 'nullable|integer',
            'najgolema_konstruktivna_vkupna_masa_po_oski_4' => 'nullable|integer',
            'najgolema_konstruktivna_vkupna_masa_po_oski_5' => 'nullable|integer',
            'oznaka_na_odobrenie_na_priklucen_ured' => 'nullable',
            'id_br_na_motorot' => 'nullable',
            'br_na_sedista' => 'nullable|integer',
            'br_na_mesta_za_stoenje' => 'nullable|integer',
            'br_na_mesta_za_lezenje' => 'nullable|integer',
            'max_brzina' => 'nullable|integer',
            'zabeleski' => 'nullable',
            'baratel' => 'nullable',
            'broj_na_dokument' => 'nullable',
            'client' => 'nullable|exists:clients,id',
            'subject' => 'nullable|exists:subjects,id',
            'photo_pdf_3' => 'nullable|file',
            'photo_pdf_4' => 'nullable|file',
            'photo_3' => 'nullable|image',
            'photo_4' => 'nullable|image',
            'photo_5' => 'nullable|image',
            'photo_6' => 'nullable|image',
            'photo_7' => 'nullable|image',
            'photo_8' => 'nullable|image',
            'notes_co2' => 'nullable',
            'color' => 'exists:colors,id|nullable',
            'color2' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'doctype.required' => 'Мора да се избере тип на документ.',
            'doctype.exists' => 'Избраниот тип на документ не постои.',
            'marka.required_if' => 'Полето „Марка“ е задолжително кога типот на документ е 1 или 3.',
            'fuel.exists' => 'Избраното гориво не постои во базата на податоци.',
            'fuel.required_if' => 'Полето „Гориво“ е задолжително кога типот на документ е 1 или 3.',
            'tip.required_if' => 'Полето „Тип“ е задолжително кога типот на документ е 1 или 3.',
            'varijanta.required_if' => 'Полето „Варијанта“ е задолжително кога типот на документ е 1 или 3.',
            'izvedba.required_if' => 'Полето „Изведба“ е задолжително кога типот на документ е 1 или 3.',
            'cm3.integer' => 'Вредноста за „CM3“ мора да биде цел број.',
            'cm3.max' => 'Вредноста за „CM3“ не смее да биде поголема од 50.000.',
            'cm3.required_if' => 'Полето „CM3“ е задолжително кога типот на документ е 1 или 3.',
            'kw.integer' => 'Вредноста за „KW“ мора да биде цел број.',
            'kw.max' => 'Вредноста за „KW“ не смее да биде поголема од 20.000.',
            'kw.required_if' => 'Полето „KW“ е задолжително кога типот на документ е 1 или 3.',
            'co2_nedc.integer' => 'Вредноста за „CO2 (NEDC)“ мора да биде цел број.',
            'co2_nedc.max' => 'Вредноста за „CO2 (NEDC)“ не смее да биде поголема од 500.',
            'co2_nedc.required_without' => 'Мора да се внесе барем „CO2 (NEDC)“ или „CO2 (WLTP)“.',
            'co2_nedc.required_if' => 'Полето „CO2 (NEDC)“ е задолжително кога типот на документ е 1 или 3.',
            'co2_wltp.integer' => 'Вредноста за „CO2 (WLTP)“ мора да биде цел број.',
            'co2_wltp.max' => 'Вредноста за „CO2 (WLTP)“ не смее да биде поголема од 500.',
            'co2_wltp.required_without' => 'Мора да се внесе барем „CO2 (WLTP)“ или „CO2 (NEDC)“.',
            'co2_wltp.required_if' => 'Полето „CO2 (WLTP)“ е задолжително кога типот на документ е 1 или 3.',
            'file.required_if' => 'Полето за документ е задолжително кога типот на документ е 1 или 3.',
            'file.mimes' => 'Документот мора да биде во jpg,jpeg,png,webp или pdf формат.',
            'file.max' => 'Документот не смее да биде поголем од 10MB.',
            'godina_na_proizvodstvo.digits' => 'Годината на производство мора да содржи точно 4 цифри.',
            'godina_na_proizvodstvo.integer' => 'Годината на производство мора да биде цел број.',
            'godina_na_proizvodstvo.min' => 'Годината на производство не смее да биде помала од 1900.',
            'godina_na_proizvodstvo.max' => 'Годината на производство не смее да биде поголема од тековната година.',
            'najgolema_konstruktivna_vkupna_masa.integer' => 'Најголемата конструктивна вкупна маса мора да биде цел број.',
            'najgolema_legalna_vkupna_masa.integer' => 'Најголемата легална вкупна маса мора да биде цел број.',
            'najgolema_legalna_vkupna_masa_na_grupa_vozila.integer' => 'Најголемата легална вкупна маса на група возила мора да биде цел број.',
            'masa_na_voziloto.integer' => 'Масата на возилото мора да биде цел број.',
            'broj_na_oski.integer' => 'Бројот на оски мора да биде цел број.',
            'dolzina.regex' => 'Должината мора да биде цел број или опсег од броеви (пр. 150 или 150-160).',
            'sirina.regex' => 'Ширината мора да биде цел број или опсег од броеви (пр. 150 или 150-160).',
            'visina.regex' => 'Висината мора да биде цел број или опсег од броеви (пр. 150 или 150-160).',
            'broj_na_vrtezi.integer' => 'Бројот на вртежи мора да биде цел број.',
            'vin.regex' => 'VIN бројот мора да содржи точно 17 знаци (букви и броеви, без I, O, Q).',
            // 'vin.unique' => 'VIN бројот веќе се наоѓа во базата со податоци',
            'datum_na_dokument.required' => 'Полето „Датум на документ“ е задолжително.',
            'datum_na_dokument.date' => 'Вредноста за „Датум на документ“ мора да биде валиден датум.',
            'stacionarna_bucavost.integer' => 'Стационарната бучавост мора to be цел број.',
            'brzina_na_vrtenje.integer' => 'Брзината на вртење мора да биде цел број.',
            'najgolemo_konstr_osno_optovaruvanje_1.integer' => 'Најголемото конструктивно осно оптоварување 1 мора да биде цел број.',
            'najgolemo_konstr_osno_optovaruvanje_2.integer' => 'Најголемото конструктивно осно оптоварување 2 мора да биде цел број.',
            'najgolemo_konstr_osno_optovaruvanje_3.integer' => 'Најголемото конструктивно осно оптоварување 3 мора да биде цел број.',
            'najgolemo_konstr_osno_optovaruvanje_4.integer' => 'Најголемото конструктивно осно оптоварување 4 мора да биде цел број.',
            'najgolemo_konstr_osno_optovaruvanje_5.integer' => 'Најголемото конструктивно осно оптоварување 5 мора да биде цел број.',
            'priklucna_tocka.integer' => 'Приклучната точка мора да биде цел број.',
            'additional_doc_1.file' => 'Дополнителниот документ 1 мора да биде во PDF формат.',
            'additional_doc_2.file' => 'Дополнителниот документ 2 мора да биде во PDF формат.',
            'coc_doc.file' => 'Европското Одобрение документот мора да биде датотека во PDF формат.',
            'trailer.integer' => 'Вредноста за приколка мора да биде цел број.',
            'unbreaked_trailer.integer' => 'Вредноста за некочена приколка мора да биде цел број.',
            'photo_pdf_1.file' => 'Фото PDF 1 мора да биде во PDF формат.',
            'photo_pdf_2.file' => 'Фото PDF슨 мора да биде во PDF формат.',
            'photo_1.image' => 'Фото 1 мора да биде слика.',
            'photo_2.image' => 'Фото 2 мора да биде слика.',

            'arhivski_broj.unique' => 'Архивскиот број веќе се наоѓа во базата со податоци.',
            'najgolema_konstruktivna_vkupna_masa_po_oski_1.integer' => 'Вредноста за „Најголема конструктивна вкупна маса по оски 1" мора да биде цел број.',
            'najgolema_konstruktivna_vkupna_masa_po_oski_2.integer' => 'Вредноста за „Најголема конструктивна вкупна маса по оски 2" мора да биде цел број.',
            'najgolema_konstruktivna_vkupna_masa_po_oski_3.integer' => 'Вредноста за „Најголема конструктивна вкупна маса по оски 3" мора да биде цел број.',
            'najgolema_konstruktivna_vkupna_masa_po_oski_4.integer' => 'Вредноста за „Најголема конструктивна вкупна маса по оски 4" мора да биде цел број.',
            'najgolema_konstruktivna_vkupna_masa_po_oski_5.integer' => 'Вредноста за „Најголема конструктивна вкупна маса по оски 5" мора да биде цел број.',
            'oznaka_na_odobrenie_na_priklucen_ured' => 'Вредноста за „Ознака на одобрение на приклучен уред" не е валидна.',
            'id_br_na_motorot' => 'Вредноста за „ИД број на моторот" не е валидна.',
            'br_na_sedista.integer' => 'Вредноста за „Број на седишта" мора да биде цел број.',
            'br_na_mesta_za_stoenje.integer' => 'Вредноста за „Број на места за стоење" мора да биде цел број.',
            'br_na_mesta_za_lezenje.integer' => 'Вредноста за „Број на места за лежење" мора да биде цел број.',
            'max_brzina.integer' => 'Вредноста за „Максимална брзина" мора да биде цел број.',
            'client.exists' => 'Избраниот барател не постои во системот.',
            'subject.exists' => 'Избраниот субјект не постои во системот.',

            'photo_pdf_3.file' => 'Фото PDF 3 мора да биде во PDF формат.',
            'photo_pdf_4.file' => 'Фото PDF 4 мора да биде во PDF формат.',
            'photo_3.image' => 'Фото 3 мора да биде слика.',
            'photo_4.image' => 'Фото 4 мора да биде слика.',
            'photo_5.image' => 'Фото 5 мора да биде слика.',
            'photo_6.image' => 'Фото 6 мора да биде слика.',
            'photo_7.image' => 'Фото 7 мора да биде слика.',
            'photo_8.image' => 'Фото 8 мора да биде слика.',
            'notes_co2' => 'Забелешките за CO2 не се валидни.',
            'color.exists' => 'Избраната боја не постои во базата на податоци.',

        ];
    }

}

