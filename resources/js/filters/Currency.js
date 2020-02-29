export default function (value) {
    if (!value) return '';
    return '$' + parseFloat(value).toFixed(2);
}
