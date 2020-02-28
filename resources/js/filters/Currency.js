export default function (value) {
    console.log(value);
    if (!value) return '';
    return '$' + parseInt(value);
}
