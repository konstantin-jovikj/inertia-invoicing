<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/js/app.js')

</head>

<body>
    <div class="">
        <header class="w-full px-6 flex m-auto justify-between text-[10px] font-black uppercase leading-[12px]">
            <div>
                <p>CE Декларација за усогласеност</p>
                <p>CE Declaration of Conformity</p>
                <p>Dichiarazione di conformità CE</p>
                <p>CE-Konformitätserklärung</p>
                <p>Déclaration de conformité CE</p>
                <p>Declaración de conformidad CE</p>
                <p>Declaração de conformidade CE</p>
                <p>Dearbhú Comhréireachta CE</p>
            </div>

            <div class="">
                <p>CE-conformiteitsverklaring</p>
                <p>CE-overensstemmelseserklæring</p>
                <p>CE-försäkran om överensstämmelse</p>
                <p>CE-vaatimustenmukaisuusvakuutus</p>
                <p>Δήλωση Συμμόρφωσης CE</p>
                <p>Prohlášení o shodě CE</p>
                <p>CE vastavusdeklaratsioon</p>
                <p>Izjava o sukladnosti CE</p>
            </div>

            <div>
                <p>CE megfelelőségi nyilatkozat</p>
                <p>CE atitikties deklaracija</p>
                <p>CE atbilstības deklarācija</p>
                <p>Deklaracja zgodności CE</p>
                <p>CE vyhlásenie o zhode</p>
                <p>Izjava o skladnosti CE</p>
                <p>Декларация за съответствие CE</p>
            </div>
        </header>
        <main class="w-full  px-6 mt-4">
            <div class="leading-[9px] text-[8px] text-balance">
                <p><span class="font-bold">MK</span><span> - </span>Долупотпишаното авторизирано лице од
                    {{ $product->document->owner->name }}, ul:{{ $product->document->owner->address }} -
                    {{ $product->document->owner->place->zip }} {{ $product->document->owner->place->place }} -
                    {{ $product->document->owner->place->country->name }}, изјавува дека долунаведените производи се
                    произведени за:</p>
                <p><span class="font-bold">BG</span><span> - </span>Упълномощеното лице от
                    {{ $product->document->owner->name }}, ul:{{ $product->document->owner->address }} -
                    {{ $product->document->owner->place->zip }} {{ $product->document->owner->place->place }} -
                    {{ $product->document->owner->place->country->name }}, декларира, че долупосочените продукти са
                    произведени за:</p>
                <p><span class="font-bold">HR</span><span> - </span>Ovlaštena osoba iz
                    {{ $product->document->owner->name }}, ul:{{ $product->document->owner->address }} -
                    {{ $product->document->owner->place->zip }} {{ $product->document->owner->place->place }} -
                    {{ $product->document->owner->place->country->name }}, izjavljuje da su dolje navedeni proizvodi
                    proizvedeni za:</p>
                <p><span class="font-bold">GA</span><span> - </span>Dearbhaíonn an duine údaraithe ó
                    {{ $product->document->owner->name }}, ul:{{ $product->document->owner->address }} -
                    {{ $product->document->owner->place->zip }} {{ $product->document->owner->place->place }} -
                    {{ $product->document->owner->place->country->name }},Poblacht Mhacadóine, go ndearnadh na táirgí
                    thíosluaite do:</p>
                <p><span class="font-bold">CS</span><span> - </span>Autorizovaná osoba ze společnosti
                    {{ $product->document->owner->name }}, ul:{{ $product->document->owner->address }} -
                    {{ $product->document->owner->place->zip }} {{ $product->document->owner->place->place }} -
                    {{ $product->document->owner->place->country->name }},prohlašuje, že níže uvedené výrobky byly
                    vyrobeny pro:</p>
                <p><span class="font-bold">DA</span><span> - </span>Den autoriserede repræsentant fra
                    {{ $product->document->owner->name }}, ul:{{ $product->document->owner->address }} -
                    {{ $product->document->owner->place->zip }} {{ $product->document->owner->place->place }} -
                    {{ $product->document->owner->place->country->name }},erklærer, at de nedenfor nævnte produkter er
                    fremstillet til:</p>
                <p><span class="font-bold">DE</span><span> - </span>Die unterzeichnete bevollmächtigte Person von
                    {{ $product->document->owner->name }}, ul:{{ $product->document->owner->address }} -
                    {{ $product->document->owner->place->zip }} {{ $product->document->owner->place->place }} -
                    {{ $product->document->owner->place->country->name }},erklärt, dass die unten aufgeführten Produkte
                    hergestellt wurden für:</p>
                <p><span class="font-bold">EL</span><span> - </span>Το εξουσιοδοτημένο πρόσωπο της
                    {{ $product->document->owner->name }}, ul:{{ $product->document->owner->address }} -
                    {{ $product->document->owner->place->zip }} {{ $product->document->owner->place->place }} -
                    {{ $product->document->owner->place->country->name }}, δηλώνει ότι τα παρακάτω προϊόντα
                    κατασκευάστηκαν για:</p>
                <p><span class="font-bold">EN</span><span> - </span>The undersigned authorized person from
                    {{ $product->document->owner->name }}, ul:{{ $product->document->owner->address }} -
                    {{ $product->document->owner->place->zip }} {{ $product->document->owner->place->place }} -
                    {{ $product->document->owner->place->country->name }}, declares that the products listed below are
                    manufactured for:</p>
                <p><span class="font-bold">ES</span><span> - </span>La persona autorizada de
                    {{ $product->document->owner->name }}, ul:{{ $product->document->owner->address }} -
                    {{ $product->document->owner->place->zip }} {{ $product->document->owner->place->place }} -
                    {{ $product->document->owner->place->country->name }}, declara que los productos mencionados a
                    continuación han sido fabricados para:</p>
                <p><span class="font-bold">ET</span><span> - </span>{{ $product->document->owner->name }},volitatud
                    isi, ul:{{ $product->document->owner->address }} - {{ $product->document->owner->place->zip }}
                    {{ $product->document->owner->place->place }} -
                    {{ $product->document->owner->place->country->name }}, kinnitab, et allpool loetletud tooted on
                    valmistatud:</p>
                <p><span class="font-bold">FI</span><span> - </span>{{ $product->document->owner->name }},valtuutettu
                    henkilö, ul:{{ $product->document->owner->address }} - {{ $product->document->owner->place->zip }}
                    {{ $product->document->owner->place->place }} -
                    {{ $product->document->owner->place->country->name }}, vakuuttaa, että alla luetellut tuotteet on
                    valmistettu:</p>
                <p><span class="font-bold">FR</span><span> - </span>La personne autorisée de
                    {{ $product->document->owner->name }}, ul:{{ $product->document->owner->address }} -
                    {{ $product->document->owner->place->zip }} {{ $product->document->owner->place->place }} -
                    {{ $product->document->owner->place->country->name }}, déclare que les produits mentionnés
                    ci-dessous sont fabriqués pour :</p>
                <p><span class="font-bold">HU</span><span> - </span>A {{ $product->document->owner->name }},
                    ul:{{ $product->document->owner->address }} - {{ $product->document->owner->place->zip }}
                    {{ $product->document->owner->place->place }} -
                    {{ $product->document->owner->place->country->name }}, meghatalmazott képviselője kijelenti, hogy
                    az alábbi termékek a következők számára készültek:</p>
                <p><span class="font-bold">IT</span><span> - </span>La persona autorizzata di
                    {{ $product->document->owner->name }}, ul:{{ $product->document->owner->address }} -
                    {{ $product->document->owner->place->zip }} {{ $product->document->owner->place->place }} -
                    {{ $product->document->owner->place->country->name }}, dichiara che i prodotti sotto elencati sono
                    stati fabbricati per:</p>
                <p><span class="font-bold">LT</span><span> - </span>Įgaliotas
                    {{ $product->document->owner->name }},atstovas ul:{{ $product->document->owner->address }} -
                    {{ $product->document->owner->place->zip }} {{ $product->document->owner->place->place }} -
                    {{ $product->document->owner->place->country->name }}, pareiškia, kad toliau išvardyti gaminiai
                    buvo pagaminti:</p>
                <p><span class="font-bold">LV</span><span> - </span> {{ $product->document->owner->name }},pilnvarotā
                    persona, ul:{{ $product->document->owner->address }} - {{ $product->document->owner->place->zip }}
                    {{ $product->document->owner->place->place }} -
                    {{ $product->document->owner->place->country->name }}, paziņo, ka zemāk minētie produkti ir ražoti
                    priekš:</p>
                <p><span class="font-bold">MT</span><span> - </span>Il-persuna awtorizzata minn
                    {{ $product->document->owner->name }}, ul:{{ $product->document->owner->address }} -
                    {{ $product->document->owner->place->zip }} {{ $product->document->owner->place->place }} -
                    {{ $product->document->owner->place->country->name }}, tiddikjara li l-prodotti msemmija hawn taħt
                    ġew manifatturati għal:</p>
                <p><span class="font-bold">NL</span><span> - </span>De gemachtigde persoon van
                    {{ $product->document->owner->name }}, ul:{{ $product->document->owner->address }} -
                    {{ $product->document->owner->place->zip }} {{ $product->document->owner->place->place }} -
                    {{ $product->document->owner->place->country->name }}, verklaart dat de onderstaande producten zijn
                    vervaardigd voor:</p>
                <p><span class="font-bold">PL</span><span> - </span>Upoważniona osoba z
                    {{ $product->document->owner->name }}, ul:{{ $product->document->owner->address }} -
                    {{ $product->document->owner->place->zip }} {{ $product->document->owner->place->place }} -
                    {{ $product->document->owner->place->country->name }}, oświadcza, że poniższe produkty zostały
                    wyprodukowane dla:</p>
                <p><span class="font-bold">PT</span><span> - </span>A pessoa autorizada da
                    {{ $product->document->owner->name }}, ul:{{ $product->document->owner->address }} -
                    {{ $product->document->owner->place->zip }} {{ $product->document->owner->place->place }} -
                    {{ $product->document->owner->place->country->name }}, declara que os produtos listados abaixo
                    foram fabricados para:</p>
                <p><span class="font-bold">RO</span><span> - </span>Persoana autorizată de la
                    {{ $product->document->owner->name }}, ul:{{ $product->document->owner->address }} -
                    {{ $product->document->owner->place->zip }} {{ $product->document->owner->place->place }} -
                    {{ $product->document->owner->place->country->name }}, declară că produsele enumerate mai jos sunt
                    fabricate pentru:</p>
                <p><span class="font-bold">SK</span><span> - </span>Autorizovaná osoba zo spoločnosti
                    {{ $product->document->owner->name }}, ul:{{ $product->document->owner->address }} -
                    {{ $product->document->owner->place->zip }} {{ $product->document->owner->place->place }} -
                    {{ $product->document->owner->place->country->name }},vyhlasuje, že nižšie uvedené výrobky boli
                    vyrobené pre:</p>
                <p><span class="font-bold">SL</span><span> - </span>Pooblaščena oseba iz
                    {{ $product->document->owner->name }}, ul:{{ $product->document->owner->address }} -
                    {{ $product->document->owner->place->zip }} {{ $product->document->owner->place->place }} -
                    {{ $product->document->owner->place->country->name }},izjavljam, da so spodaj navedeni izdelki
                    izdelani za:</p>
                <p><span class="font-bold">SV</span><span> - </span>Den auktoriserade personen från
                    {{ $product->document->owner->name }}, ul:{{ $product->document->owner->address }} -
                    {{ $product->document->owner->place->zip }} {{ $product->document->owner->place->place }} -
                    {{ $product->document->owner->place->country->name }},intygar att följande produkter är
                    tillverkade för:</p>
            </div>
            <div class="w-full mx-auto  flex justify-center mt-2">
                <div class="w-[200px] ">
                    <img src="{{ asset('storage/' . $product->document->owner->logo) }}" alt="Logo">
                </div>
            </div>
            <div
                class="w-full mx-auto  flex justify-center mt-2 border border-gray-700 rounded-md py-2 font-bold uppercase">
                @if ($product->model)
                    <p>{{ $product->model->model }}</p>
                @endif
            </div>
            {{-- Direktivi --}}

            <div class="w-full leading-[8px] text-[7px] flex mt-2">
                <div class="w-2/6">
                    <p><span class="font-bold">MK</span><span> - </span>Се во согласност со следниве директиви:</p>
                    <p><span class="font-bold">BG</span><span> - </span>В съответствие със следните директиви:</p>
                    <p><span class="font-bold">HR</span><span> - </span>U skladu sa sljedećim direktivama:</p>
                    <p><span class="font-bold">GA</span><span> - </span>I gcomhréir leis na treoracha seo a leanas:</p>
                    <p><span class="font-bold">CS</span><span> - </span>V souladu s následujícími směrnicemi:</p>
                    <p><span class="font-bold">DA</span><span> - </span>I overensstemmelse med følgende direktiver:</p>
                    <p><span class="font-bold">DE</span><span> - </span>In Übereinstimmung mit den folgenden
                        Richtlinien:</p>
                    <p><span class="font-bold">EL</span><span> - </span>Σύμφωνα με τις ακόλουθες οδηγίες:</p>
                    <p><span class="font-bold">EN</span><span> - </span>In compliance with the following directives:</p>
                    <p><span class="font-bold">ES</span><span> - </span>De conformidad con las siguientes directivas:
                    </p>
                    <p><span class="font-bold">ET</span><span> - </span>Vastavuses järgmiste direktiividega:</p>
                    <p><span class="font-bold">FI</span><span> - </span>Yhdenmukaisuus seuraavien direktiivien kanssa:
                    </p>
                    <p><span class="font-bold">FR</span><span> - </span>En conformité avec les directives suivantes:</p>
                </div>

                <div class="w-2/6">
                    <p><span class="font-bold">HU</span><span> - </span>Az alábbi irányelveknek megfelelően:</p>
                    <p><span class="font-bold">IT</span><span> - </span>In conformità con le seguenti direttive:</p>
                    <p><span class="font-bold">LT</span><span> - </span>Laikantis šių direktyvų:</p>
                    <p><span class="font-bold">LV</span><span> - </span>Atbilst šādām direktīvām:</p>
                    <p><span class="font-bold">MT</span><span> - </span>F’konformità mad-direttivi li ġejjin:</p>
                    <p><span class="font-bold">NL</span><span> - </span>In overeenstemming met de volgende richtlijnen:
                    </p>
                    <p><span class="font-bold">PL</span><span> - </span>Zgodnie z następującymi dyrektywami:</p>
                    <p><span class="font-bold">PT</span><span> - </span>Em conformidade com as seguintes diretivas:</p>
                    <p><span class="font-bold">RO</span><span> - </span>În conformitate cu următoarele directive:</p>
                    <p><span class="font-bold">SK</span><span> - </span>V súlade s nasledujúcimi smernicami:</p>
                    <p><span class="font-bold">SL</span><span> - </span>V skladu z naslednjimi direktivami:</p>
                    <p><span class="font-bold">SV</span><span> - </span>I överensstämmelse med följande direktiv:</p>
                </div>

                <div class="w-2/6 text-[10px] font-bold text-balance h-[100px]  leading-[12px] break-words"
                    style="column-count: 2; column-gap: 3px;">
                    @if ($product->categories)
                        @foreach ($product->categories->directives as $directive)
                            <li>{{ $directive->directive }}</li>
                        @endforeach
                    @endif
                </div>

            </div>

            {{-- Regulativi --}}

            <div class="w-full leading-[8px] text-[7px] flex mt-2">
                <div class="w-1/5">
                    <p><span class="font-bold">MK</span><span> - </span>И со следниве стандарди:</p>
                    <p><span class="font-bold">BG</span><span> - </span>И със следните стандарти:</p>
                    <p><span class="font-bold">HR</span><span> - </span>I sa sljedećim standardima:</p>
                    <p><span class="font-bold">GA</span><span> - </span>I gcomhréir leis na treoracha seo a leanas:</p>
                    <p><span class="font-bold">CS</span><span> - </span>A s následujícími normami:</p>
                    <p><span class="font-bold">DA</span><span> - </span>Og med følgende standarder:</p>
                    <p><span class="font-bold">DE</span><span> - </span>Und mit den folgenden Normen:</p>
                    <p><span class="font-bold">EL</span><span> - </span>Και με τα ακόλουθα πρότυπα:</p>
                    <p><span class="font-bold">EN</span><span> - </span>And with the following standards:</p>
                    <p><span class="font-bold">ES</span><span> - </span>Y con las siguientes normas:</p>
                    <p><span class="font-bold">ET</span><span> - </span>Ja järgmiste standarditega:</p>
                    <p><span class="font-bold">FI</span><span> - </span>Ja seuraavien standardien kanssa:</p>
                    <p><span class="font-bold">FR</span><span> - </span>Et avec les normes suivantes:</p>
                </div>

                <div class="w-1/5">
                    <p><span class="font-bold">HU</span><span> - </span>És a következő szabványokkal:</p>
                    <p><span class="font-bold">IT</span><span> - </span>E con i seguenti standard:</p>
                    <p><span class="font-bold">LT</span><span> - </span>Ir laikantis šių standartų:</p>
                    <p><span class="font-bold">LV</span><span> - </span>Un ar šādiem standartiem:</p>
                    <p><span class="font-bold">MT</span><span> - </span>U mal-istandards li ġejjin:</p>
                    <p><span class="font-bold">NL</span><span> - </span>En met de volgende normen:</p>
                    <p><span class="font-bold">PL</span><span> - </span>I z następującymi normami:</p>
                    <p><span class="font-bold">PT</span><span> - </span>E com as seguintes normas:</p>
                    <p><span class="font-bold">RO</span><span> - </span>Și cu următoarele standarde:</p>
                    <p><span class="font-bold">SK</span><span> - </span>A s nasledujúcimi normami:</p>
                    <p><span class="font-bold">SL</span><span> - </span>In z naslednjimi standardi:</p>
                    <p><span class="font-bold">SV</span><span> - </span>Och med följande standarder:</p>
                </div>

                <div class="w-1/5">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="120"
                        height="120" viewBox="127.502 132.666 211.045 149.993">
                        <symbol id="a" viewBox="-14.553 -26.459 29.106 52.918">
                            <path
                                d="M14.551 18.333C3.56 19.926-6.616 11.26-6.616.001S3.56-19.924 14.551-18.331v-7.994C-.851-27.884-14.553-15.609-14.553.001s13.701 27.86 29.106 26.328l-.002-7.996z" />
                        </symbol>
                        <use xlink:href="#a" width="29.106" height="52.918" x="-14.553" y="-26.459"
                            transform="translate(168.753 207.663) scale(2.8345)" overflow="visible" />
                        <path d="M263.321 196.393H323.3v22.491h-59.979z" />
                        <use xlink:href="#a" width="29.106" height="52.918" x="-14.553" y="-26.459"
                            transform="matrix(2.8336 0 0 -2.8336 297.31 207.639)" overflow="visible" />
                    </svg>


                </div>

                <div class="w-2/5 text-[10px] font-bold text-balance h-[100px]  leading-[12px] "
                    style="column-count: 2; column-gap: 3px;">
                    @if ($product->categories)
                        @foreach ($product->categories->regulations as $regulation)
                            <li>{{ $regulation->regulation }}</li>
                        @endforeach
                    @endif
                </div>

            </div>

            {{-- Final Part --}}

            <div class="leading-[9px] text-[8px] text-balance">
                <p><span class="font-bold">MK</span><span> - </span>Во согласност со гореспоменатите директиви, ставена
                    е СЕ ознака. Истотака, припремена е адекватна техничка документација која е достапна во нашите
                    канцеларии.</p>
                <p><span class="font-bold">BG</span><span> - </span>В съответствие с горепосочените директиви е
                    поставена маркировка СЕ. Също така е изготвена адекватна техническа документация, която е налична в
                    нашите офиси.</p>
                <p><span class="font-bold">HR</span><span> - </span>U skladu s gore navedenim direktivama, stavljena je
                    CE oznaka. Također je pripremljena odgovarajuća tehnička dokumentacija koja je dostupna u našim
                    uredima.</p>
                <p><span class="font-bold">GA</span><span> - </span>De réir na dtreoirlínte thuasluaite, tá an mharcáil
                    CE curtha i bhfeidhm. Ina theannta sin, tá doiciméadacht theicniúil chuí ullmhaithe atá ar fáil inár
                    n-oifigí.</p>
                <p><span class="font-bold">CS</span><span> - </span>V souladu s výše uvedenými směrnicemi bylo
                    připojeno označení CE. Rovněž byla připravena odpovídající technická dokumentace, která je k
                    dispozici v našich kancelářích.</p>
                <p><span class="font-bold">DA</span><span> - </span>I overensstemmelse med de ovennævnte direktiver er
                    CE-mærket blevet påført. Derudover er der udarbejdet tilstrækkelig teknisk dokumentation, som er
                    tilgængelig på vores kontorer.</p>
                <p><span class="font-bold">DE</span><span> - </span>In Übereinstimmung mit den oben genannten
                    Richtlinien wurde die CE-Kennzeichnung angebracht. Zudem wurde eine angemessene technische
                    Dokumentation erstellt, die in unseren Büros verfügbar ist.</p>
                <p><span class="font-bold">EL</span><span> - </span>Σύμφωνα με τις προαναφερθείσες οδηγίες, έχει
                    τοποθετηθεί η σήμανση CE. Επίσης, έχει προετοιμαστεί η κατάλληλη τεχνική τεκμηρίωση που είναι
                    διαθέσιμη στα γραφεία μας.</p>
                <p><span class="font-bold">EN</span><span> - </span>In accordance with the aforementioned directives,
                    the CE marking has been affixed. Additionally, adequate technical documentation has been prepared
                    and is available at our offices.</p>
                <p><span class="font-bold">ES</span><span> - </span>De acuerdo con las directivas mencionadas
                    anteriormente, se ha colocado el marcado CE. Además, se ha preparado la documentación técnica
                    adecuada, que está disponible en nuestras oficinas.</p>
                <p><span class="font-bold">ET</span><span> - </span>Kooskõlas ülalnimetatud direktiividega on CE-märgis
                    paigaldatud. Lisaks on koostatud vastav tehniline dokumentatsioon, mis on saadaval meie kontorites.
                </p>
                <p><span class="font-bold">FI</span><span> - </span>Edellä mainittujen direktiivien mukaisesti
                    CE-merkintä on kiinnitetty. Lisäksi asianmukainen tekninen dokumentaatio on laadittu ja se on
                    saatavilla toimistoissamme.</p>
                <p><span class="font-bold">FR</span><span> - </span>Conformément aux directives mentionnées ci-dessus,
                    le marquage CE a été apposé. En outre, une documentation technique adéquate a été préparée et est
                    disponible dans nos bureaux.</p>
                <p><span class="font-bold">HU</span><span> - </span>A fent említett irányelveknek megfelelően a
                    CE-jelölést elhelyezték. Ezenkívül elkészült a megfelelő műszaki dokumentáció, amely elérhető az
                    irodáinkban.</p>
                <p><span class="font-bold">IT</span><span> - </span>In conformità con le direttive sopra menzionate, è
                    stato apposto il marchio CE. Inoltre, è stata preparata un'adeguata documentazione tecnica
                    disponibile presso i nostri uffici.</p>
                <p><span class="font-bold">LT</span><span> - </span>Pagal aukščiau paminėtas direktyvas buvo
                    pritvirtintas CE ženklas. Taip pat buvo parengta tinkama techninė dokumentacija, kuri yra prieinama
                    mūsų biuruose.</p>
                <p><span class="font-bold">LV</span><span> - </span>Saskaņā ar iepriekš minētajām direktīvām ir uzlikts
                    CE marķējums. Tāpat ir sagatavota atbilstoša tehniskā dokumentācija, kas pieejama mūsu birojos.</p>
                <p><span class="font-bold">MT</span><span> - </span> F'konformità mad-direttivi msemmija hawn fuq, ġiet
                    affixjata l-marka CE. Barra minn hekk, ġiet ippreparata dokumentazzjoni teknika adegwata li hija
                    disponibbli fl-uffiċini tagħna.</p>
                <p><span class="font-bold">NL</span><span> - </span>In overeenstemming met de bovengenoemde richtlijnen
                    is de CE-markering aangebracht. Bovendien is er adequate technische documentatie opgesteld die
                    beschikbaar is op onze kantoren.</p>
                <p><span class="font-bold">PL</span><span> - </span>Zgodnie z powyższymi dyrektywami naniesiono
                    oznakowanie CE. Ponadto została przygotowana odpowiednia dokumentacja techniczna dostępna w naszych
                    biurach.</p>
                <p><span class="font-bold">PT</span><span> - </span>De acordo com as diretrizes acima mencionadas, a
                    marcação CE foi afixada. Além disso, foi preparada a documentação técnica adequada, que está
                    disponível nos nossos escritórios.</p>
                <p><span class="font-bold">RO</span><span> - </span>În conformitate cu directivele menționate mai sus,
                    marcajul CE a fost aplicat. De asemenea, a fost pregătită o documentație tehnică adecvată,
                    disponibilă în birourile noastre.</p>
                <p><span class="font-bold">SK</span><span> - </span>V súlade s vyššie uvedenými smernicami bolo
                    umiestnené označenie CE. Taktiež bola pripravená adekvátna technická dokumentácia, ktorá je k
                    dispozícii v našich kanceláriách.</p>
                <p><span class="font-bold">SL</span><span> - </span>V skladu z zgoraj navedenimi direktivami je bila
                    dodana oznaka CE. Prav tako je bila pripravljena ustrezna tehnična dokumentacija, ki je na voljo v
                    naših pisarnah.</p>
                <p><span class="font-bold">SV</span><span> - </span>I enlighet med ovan nämnda direktiv har
                    CE-märkningen anbringats. Dessutom har adekvat teknisk dokumentation förberetts och finns
                    tillgänglig på våra kontor.</p>

            </div>


        </main>
        <footer class="w-full px-6 flex m-auto justify-between text-[8px] font-semibold uppercase leading-[12px] mt-6">
            <table class="w-1/3  text-center text-gray-800 dark:text-gray-400 border border-black h-4">
                <thead>
                    <tr class="border-b border-black ">
                        <th class="border-e border-black p-1">
                            <p>EMISSION DATE</p>
                        </th>
                        <th class="border-e border-black p-1">
                            <p>REVISION</p>
                        </th>
                        <th>
                            <p>REVISION DATE</p>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-xs ">
                        <td class="border-e border-black ">
                            01.04.2015
                        </td>
                        <td class="border-e border-black">
                            01
                        </td>
                        <td>
                            15.12.2022
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="w-1/3">

            </div>
            <div class="w-1/3">
                <div>
                    <p>Bunjamin Jashari</p>
                </div>
                <div>
                    <?xml version="1.0" standalone="no"?>
                    <!DOCTYPE svg
                        PUBLIC "-//W3C//DTD SVG 20010904//EN" "http://www.w3.org/TR/2001/REC-SVG-20010904/DTD/svg10.dtd">
                    <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="60pt" height="60pt"
                        viewBox="0 0 497.000000 304.000000" preserveAspectRatio="xMidYMid meet">

                        <g transform="translate(0.000000,304.000000) scale(0.100000,-0.100000)" fill="#000000"
                            stroke="none">
                            <path d="M2460 2947 c0 -9 -13 -14 -37 -15 -36 -2 -83 -33 -83 -57 0 -6 -21
-38 -46 -70 -56 -73 -102 -154 -161 -287 -25 -57 -48 -105 -50 -108 -9 -10
-180 -22 -318 -23 -77 -1 -234 3 -350 8 -485 22 -699 3 -915 -83 -114 -45
-131 -54 -222 -121 -81 -59 -173 -186 -200 -276 -50 -167 -34 -291 50 -378 46
-48 79 -66 162 -88 55 -15 67 -16 79 -4 20 20 7 32 -47 39 -64 8 -128 52 -172
116 -31 47 -34 58 -34 123 -1 86 40 222 87 294 36 54 105 123 124 123 7 0 13
4 13 8 0 5 19 19 43 32 23 13 57 34 75 46 18 13 47 26 65 29 18 4 37 11 42 15
19 15 116 39 223 55 133 19 358 21 637 5 195 -11 515 -7 594 7 l33 6 -7 -34
c-10 -47 -41 -105 -60 -112 -10 -4 -15 -19 -15 -42 0 -20 -7 -50 -16 -66 -8
-17 -26 -71 -39 -121 -24 -91 -40 -122 -118 -216 -43 -52 -54 -75 -82 -176
-13 -46 -12 -55 7 -110 l21 -61 -21 -67 c-12 -36 -24 -99 -28 -140 -3 -40 -14
-94 -25 -120 -10 -26 -19 -60 -19 -77 0 -26 -19 -112 -77 -356 -8 -33 -18 -80
-23 -105 -19 -99 -60 -244 -74 -259 -7 -9 -23 -35 -35 -59 -12 -23 -24 -42
-27 -42 -4 0 -24 16 -45 35 -22 19 -46 35 -55 35 -9 0 -14 6 -12 12 3 7 -4 35
-15 63 -33 88 -48 139 -42 153 3 7 -1 20 -9 28 -41 41 -72 248 -52 351 15 82
27 105 66 133 36 26 38 40 6 40 -29 0 -110 -70 -123 -107 -40 -111 -32 -267
22 -433 20 -63 53 -141 71 -173 19 -32 34 -62 34 -68 0 -5 7 -12 15 -15 8 -4
15 -12 15 -18 0 -17 59 -70 99 -89 50 -25 75 -14 102 44 13 28 31 55 41 60 12
7 16 17 12 37 -3 16 4 56 19 97 13 39 25 81 25 95 1 14 22 103 47 199 25 96
45 183 45 194 0 31 99 433 131 532 17 50 31 95 33 100 9 29 37 84 45 89 15 10
22 69 9 78 -9 6 -10 10 -2 16 19 12 41 64 54 125 10 52 16 61 64 97 53 40 149
80 192 80 31 0 44 -27 44 -90 0 -85 -37 -153 -91 -165 -38 -8 -140 -84 -169
-125 -22 -31 -22 -32 -2 -21 21 11 21 11 4 -19 -13 -23 -22 -29 -38 -26 -14 4
-32 -6 -58 -31 -33 -33 -37 -41 -34 -81 4 -64 25 -74 83 -42 75 41 151 109
221 197 36 46 70 83 74 83 29 0 63 -117 48 -164 -5 -17 -42 -98 -81 -179 -55
-116 -68 -153 -60 -165 21 -34 44 -18 88 63 23 44 58 115 75 158 18 42 34 76
36 75 1 -2 5 -24 8 -49 13 -110 71 -199 130 -199 22 0 40 11 70 44 23 24 48
59 58 77 36 74 60 129 87 204 15 43 30 74 33 69 3 -5 9 -36 13 -69 15 -128
108 -265 180 -265 59 0 131 105 175 253 19 64 57 172 129 363 22 61 41 116 41
121 0 6 9 20 20 33 19 21 20 22 20 4 0 -11 -4 -24 -9 -29 -4 -6 -18 -73 -30
-150 -13 -77 -27 -165 -32 -195 -18 -104 -23 -353 -9 -464 13 -106 24 -131 56
-124 19 3 19 2 75 123 37 78 56 103 139 186 83 83 106 100 174 128 116 48 172
58 248 42 188 -38 324 -155 426 -364 50 -101 78 -230 87 -392 11 -205 -35
-364 -133 -463 -24 -24 -63 -52 -87 -63 -43 -19 -47 -19 -102 -3 -32 9 -68 22
-80 30 -12 8 -24 10 -27 5 -9 -14 17 -38 78 -70 49 -26 66 -30 108 -26 69 7
108 28 165 88 115 122 146 219 147 462 0 168 -17 290 -54 391 -53 144 -168
297 -275 369 -90 60 -225 105 -316 105 -106 0 -328 -101 -363 -165 -6 -11 -28
-39 -48 -62 -20 -23 -44 -58 -52 -77 -9 -22 -22 -36 -32 -36 -10 0 -28 -10
-41 -22 -13 -12 -26 -18 -30 -15 -9 10 -5 280 6 362 5 39 18 131 30 205 11 74
22 208 25 298 4 140 3 164 -10 169 -34 13 -34 11 -204 -494 -101 -299 -132
-374 -169 -407 -12 -11 -21 -25 -21 -31 0 -7 -6 -17 -13 -24 -21 -17 -83 54
-107 121 -30 87 -42 219 -30 350 5 62 14 129 20 148 13 47 13 167 -1 176 -21
13 -36 -22 -53 -126 -10 -58 -28 -143 -41 -190 -13 -47 -35 -130 -50 -185 -33
-128 -99 -267 -137 -290 -15 -9 -28 -22 -28 -29 0 -19 -23 -36 -37 -28 -6 4
-20 25 -32 47 -17 32 -21 57 -21 127 0 96 23 173 82 277 55 99 68 161 32 161
-18 0 -80 -83 -95 -128 -6 -19 -27 -62 -46 -94 -33 -56 -53 -67 -53 -28 0 10
-16 39 -35 64 l-35 46 25 77 c26 77 26 115 3 175 -21 57 -120 63 -223 13 -101
-49 -97 -48 -90 -22 4 12 18 49 30 82 121 313 107 292 210 314 174 36 295 92
365 167 l42 46 -4 81 c-2 46 -11 98 -20 117 -8 19 -20 53 -27 75 -14 51 -64
105 -97 105 -13 0 -24 -6 -24 -13z m33 -55 c9 -10 20 -33 23 -50 4 -18 11 -35
15 -38 5 -3 9 -17 9 -32 0 -15 9 -40 20 -57 21 -32 27 -104 10 -135 -23 -44
-183 -117 -313 -144 -42 -9 -79 -16 -82 -16 -24 0 42 154 78 182 13 10 22 29
23 47 2 34 70 131 92 131 8 0 12 6 9 14 -8 21 42 68 65 61 15 -5 18 -1 18 24
0 35 10 39 33 13z m-135 -64 c-2 -6 -10 -14 -16 -16 -7 -2 -10 2 -6 12 7 18
28 22 22 4z m-566 -1256 c-9 -40 -20 -72 -25 -72 -8 0 -2 33 20 103 22 71 25
52 5 -31z m328 39 c0 -27 -171 -183 -185 -170 -11 11 39 72 101 123 67 55 84
65 84 47z" />
                            <path d="M4820 1955 c0 -5 5 -17 10 -25 5 -8 10 -10 10 -5 0 6 -5 17 -10 25
-5 8 -10 11 -10 5z" />
                            <path d="M4898 1890 c-7 -11 -18 -20 -24 -20 -13 0 -24 -57 -17 -77 3 -7 15
-13 28 -13 29 0 69 71 60 107 -7 28 -30 30 -47 3z" />
                        </g>
                    </svg>

                </div>
            </div>
        </footer>

    </div>
</body>

</html>
