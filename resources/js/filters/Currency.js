export default function (value) {
    if (!value) return '';
    return '$' + parseInt(value);
}
