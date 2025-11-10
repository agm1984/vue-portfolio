/**
 * Use this to escape characters that have special meaning to regex expressions.
 * For example, `\` or `|` will be replaced with `\\` or `\|`.
 */
export const escapeRegExpChars = (value) => {
    if (typeof value !== 'string') return value;
    return value.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
};
