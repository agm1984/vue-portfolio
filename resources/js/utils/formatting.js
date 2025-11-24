/**
 * Use this to escape characters that have special meaning to regex expressions.
 * For example, `\` or `|` will be replaced with `\\` or `\|`.
 */
export const escapeRegExpChars = (value) => {
    if (typeof value !== 'string') return value;
    return value.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
};

/**
 * Pure function to convert bytes to readable string.
 * formatBytes(1024) -> "1 KB"
 */
export const formatBytes = (bytes, decimals = 2) => {
    if (!+bytes) return '0 Bytes';

    const k = 1024;
    const dm = decimals < 0 ? 0 : decimals;
    const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];

    const i = Math.floor(Math.log(bytes) / Math.log(k));

    return `${parseFloat((bytes / Math.pow(k, i)).toFixed(dm))} ${sizes[i]}`;
};