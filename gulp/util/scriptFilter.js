var path = require("path");

// Filters out non .coffee and .js files. Prevents
// accidental inclusion of possible hidden files
module.exports = function(name) {
    if (name.substr(0, 1) !== '_') {
        return /(\.(js|coffee)$)/i.test(path.extname(name));
    }
    return false;
};
