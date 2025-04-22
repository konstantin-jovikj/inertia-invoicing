export function NumberToWordsMk(number) {
    if (number === 0) return "нула";

    const units = [
        "", "еден", "два", "три", "четири", "пет", "шест", "седум", "осум", "девет",
    ];
    const teens = [
        "десет", "единаесет", "дванаесет", "тринаесет", "четиринаесет",
        "петнаесет", "шеснаесет", "седумнаесет", "осумнаесет", "деветнаесет",
    ];
    const tens = [
        "", "", "дваесет", "триесет", "четириесет", "педесет",
        "шеесет", "седумдесет", "осумдесет", "деведесет",
    ];
    const hundreds = [
        "", "сто", "двеста", "триста", "четиристотини",
        "петстотини", "шестотини", "седумстотини", "осумстотини", "деветстотини",
    ];
    const thousands = ["", "илјада", "илјади"];
    const millions = ["", "милион", "милиони"];

    let words = "";

    if (number >= 1000000) {
        const millionPart = Math.floor(number / 1000000);
        number %= 1000000;
        words += NumberToWordsMk(millionPart) + " ";
        words += millionPart === 1 ? millions[1] : millions[2];
        if (number > 0) words += " и ";
    }

    if (number >= 1000) {
        const thousandPart = Math.floor(number / 1000);
        number %= 1000;
        words += NumberToWordsMk(thousandPart) + " ";
        words += thousandPart === 1 ? thousands[1] : thousands[2];
        if (number > 0) words += " и ";
    }

    if (number >= 100) {
        const hundredPart = Math.floor(number / 100);
        number %= 100;
        words += hundreds[hundredPart];
        if (number > 0) words += " и ";
    }

    if (number >= 10 && number < 20) {
        words += teens[number - 10];
    } else {
        const tenPart = Math.floor(number / 10);
        const unitPart = number % 10;

        if (tenPart > 0) {
            words += tens[tenPart];
            if (unitPart > 0) words += " и ";
        }

        if (unitPart > 0) words += units[unitPart];
    }

    return words;
}