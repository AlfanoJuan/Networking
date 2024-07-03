function hashCode(str) { // java String#hashCode
    var hash = 0;
    for (var i = 0; i < str.length ; i++) {
        hash = str.charCodeAt(i) + ((hash << 5) - hash);
    }
    return hash;
} 

function intToRGB(i){
    var c = (i & 0x00FFFFFF)
        .toString(16)
        .toUpperCase();

    var color = "00000".substring(0, 6 - c.length) + c;

    return String(color);
}