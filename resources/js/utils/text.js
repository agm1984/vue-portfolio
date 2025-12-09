/**
 * Pluralizes a noun based on the count provided.
 * Supports basic pluralization rules (adds 's' or changes 'y' to 'ies').
 * @param {*} count
 * @param {*} noun
 * @returns String
 */
export const pluralize = (count, noun) => {
    if (noun.endsWith('y')) {
        return count === 1 ? noun : `${noun.slice(0, -1)}ies`;
    }

    return count === 1 ? noun : `${noun}s`;
};
