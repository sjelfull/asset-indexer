function serialize(object, prefix) {
    let string = [];

    for(var property in object) {
        if (object.hasOwnProperty(property)) {
            let key = prefix ? prefix + "[" + property + "]" : property, value = object[property];
            string.push(typeof value == "object" ?
                serialize(value, key) :
                encodeURIComponent(key) + "=" + encodeURIComponent(value));
        }
    }

    return string.join("&");
}

export default serialize
