export default function (value) {
    if (!value && value !== 0) return '';
    return '$' + parseFloat(value).toFixed(2);
}
