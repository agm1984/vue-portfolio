function randomColor() { // eslint-disable-line no-unused-vars
    let color;
    color = Math.floor(Math.random() * 0x1000000); // integer between 0x0 and 0xFFFFFF
    color = color.toString(16); // convert to hex
    color = (`000000${color}`).slice(-6); // pad with leading zeros
    color = `#${color}`; // prepend #
    return color;
}

function invertColor(hexTripletColor) { // eslint-disable-line no-unused-vars
    let color = hexTripletColor;
    color = color.substring(1); // remove #
    color = parseInt(color, 16); // convert to integer
    // eslint-disable-next-line no-bitwise
    color ^= 0xFFFFFF; // invert three bytes
    color = color.toString(16); // convert to hex
    color = (`000000${color}`).slice(-6); // pad with leading zeros
    color = `#${color}`; // prepend #
    return color;
}

/**
 * This utility is going to input a colour and output the inverse of it.
 *
 * @param {String} fromHex ex) #85e9b6
 */
const invertColour = (fromHex) => {
    let color = fromHex;
    color = color.substring(1); // remove #
    color = parseInt(color, 16); // convert to integer
    // eslint-disable-next-line no-bitwise
    color ^= 0xFFFFFF; // invert three bytes
    color = color.toString(16); // convert to hex
    color = (`000000${color}`).slice(-6); // pad with leading zeros
    color = `#${color}`; // prepend #
    return color;
};

export default invertColour;
