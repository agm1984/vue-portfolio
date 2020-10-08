/**
 * You are free to add more sizes as needed, but make sure
 * they are divisible by 2, 4, 8, 16, 32, and/or 64, because
 * these are derived from 'factors of 16'.
 *
 * For example, if you are using `w-32` and you discover that
 * margin/padding of 28 or 40 will not solve your problem,
 * then maybe you need 32+2 or 32+4, so feel free to add 34 or 36.
 *
 * Try to solve your problem without adding sizes. The fact that you
 * appear to need to add a size may indicate a different solution
 * should be looked for. This is true except when working in larger
 * sizes, such as greater than 64. If 128, 256, or 512 do not meet
 * your width/height needs, try 128+64 or 256+128, etc.
 *
 * Also, try to avoid using `style=""` prop unless you know what
 * you're doing because media queries cannot be applied to them.
 *
 * In this project, font-size is 10px for the <html> element,
 * and base font-size is 1.6rem for the <body>. This means `1px`
 * is equal to `0.1rem`, so your math conversions are simple.
 * Use REM and pretend they are pixels but with the decimal shifted
 * by one place. 6.4rem is 64px.
 *
 * This base16 scaling strategy is heavily inspired by the Fibonacci
 * sequence and the golden ratio. Note that 16px to 10px is a rounded
 * version of the ratio 1.618:1. Knowing this, designs tend to be
 * pleasant on the eyes without conscious effort.
 *
 * Atomic design: http://bradfrost.com/blog/post/atomic-web-design/
 * Tailwind docs: https://next.tailwindcss.com/docs/what-is-tailwind/
 *
 */

const availableSizes = {
    1: '0.1rem',
    2: '0.2rem', // 1/8 standard-padding/margin
    4: '0.4rem', // 1/4 standard-padding/margin
    8: '0.8rem', // 1/2 standard-padding/margin
    10: '1.0rem',
    12: '1.2rem', // 16 minus 4
    14: '1.4rem', // used to align checkboxes with no labels
    16: '1.6rem', // 1x standard padding/margin, base font size
    20: '2.0rem', // 16 plus 4
    24: '2.4rem',
    28: '2.8rem',
    32: '3.2rem', // 2x standard padding/margin
    36: '3.6rem',
    40: '4.0rem', // small row height
    48: '4.8rem', // standard input row height
    56: '5.6rem', // 48+8=56, and 64-8=56
    64: '6.4rem', // 4x standard standard padding/margin, standard header height
    72: '7.2rem', // 80-8 (aka 64+8)
    80: '8.0rem',
    88: '8.8rem', // 80+8 (aka 96-8)
    96: '9.6rem', // header row height for H1 headings
    112: '11.2rem',
    128: '12.8rem',
    144: '14.4rem',
    160: '16.0rem', // 192-32 (aka 144+16)
    192: '19.2rem',
    224: '22.4rem', // 192+32 (aka 256-32)
    256: '25.6rem',
    320: '32.0rem', // 256+64
    352: '35.2rem', // 256+96
    384: '38.4rem', // 256+128
    416: '41.6rem', // 384+32 (aka 448-32)
    448: '44.8rem', // 256+128+64 (aka 512-64)
    512: '51.2rem',
    640: '64.0rem',
    768: '76.8rem',
    1024: '102.4rem',
    1280: '128.0rem',
    1600: '160.0rem',
    2048: '204.8rem',
};

module.exports = {
    prefix: '',
    important: false,
    separator: ':',
    purge: [
        './src/**/*.html',
        './src/**/*.vue',
        './src/**/*.jsx',
    ],
    theme: {
        colors: {
            transparent: 'transparent',
            black: '#000000',
            white: '#ffffff',

            // transparent black https://www.colorcodehex.com/1d262f.html
            'transparent-black': 'rgba(29, 38, 47, 0.96)',

            primary: '#006666',
            'primary-hover': '#005959',
            'primary-active': '#004d4d',
            'primary-text': '#339999',

            secondary: '#006699',
            'secondary-hover': '#005580',
            'secondary-active': '#004466',

            mint: '#47ebb4',
            'mint-hover': '#0aa370',
            'mint-active': 'rgba(10, 163, 112, 0.2)',

            accent: '#ffcc99',

            olive: '#999966',
            rose: '#996666',
            lilac: '#666699',
            'pale-yellow': '#ffcc66',

            github: '#474e52',
            'github-hover': '#3b3f44',
            'github-active': '#2f3237',
            twitter: '#006699',
            'twitter-hover': '#005580',
            'twitter-active': '#004466',

            grey: {
                100: '#f7fafc',
                200: '#edf2f7',
                300: '#e2e8f0',
                400: '#cbd5e0',
                500: '#a0aec0',
                600: '#718096',
                700: '#4a5568',
                800: '#2d3748',
                900: '#1a202c',
            },
            red: {
                100: '#fff5f5',
                200: '#fed7d7',
                300: '#feb2b2',
                400: '#fc8181',
                500: '#f56565',
                600: '#e53e3e',
                700: '#c53030',
                800: '#9b2c2c',
                900: '#742a2a',
            },
            orange: {
                100: '#fffaf0',
                200: '#feebc8',
                300: '#fbd38d',
                400: '#f6ad55',
                500: '#ed8936',
                600: '#dd6b20',
                700: '#c05621',
                800: '#9c4221',
                900: '#7b341e',
            },
            yellow: {
                100: '#fffff0',
                200: '#fefcbf',
                300: '#faf089',
                400: '#f6e05e',
                500: '#ecc94b',
                600: '#d69e2e',
                700: '#b7791f',
                800: '#975a16',
                900: '#744210',
            },
            green: {
                100: '#f0fff4',
                200: '#c6f6d5',
                300: '#9ae6b4',
                400: '#68d391',
                500: '#48bb78',
                600: '#38a169',
                700: '#2f855a',
                800: '#276749',
                900: '#22543d',
            },
            teal: {
                100: '#e6fffa',
                200: '#b2f5ea',
                300: '#81e6d9',
                400: '#4fd1c5',
                500: '#38b2ac',
                600: '#319795',
                700: '#2c7a7b',
                800: '#285e61',
                900: '#234e52',
            },
            blue: {
                100: '#ebf8ff',
                200: '#bee3f8',
                300: '#90cdf4',
                400: '#63b3ed',
                500: '#4299e1',
                600: '#3182ce',
                700: '#2b6cb0',
                800: '#2c5282',
                900: '#2a4365',
            },
            indigo: {
                100: '#ebf4ff',
                200: '#c3dafe',
                300: '#a3bffa',
                400: '#7f9cf5',
                500: '#667eea',
                600: '#5a67d8',
                700: '#4c51bf',
                800: '#434190',
                900: '#3c366b',
            },
            purple: {
                100: '#faf5ff',
                200: '#e9d8fd',
                300: '#d6bcfa',
                400: '#b794f4',
                500: '#9f7aea',
                600: '#805ad5',
                700: '#6b46c1',
                800: '#553c9a',
                900: '#44337a',
            },
            pink: {
                100: '#fff5f7',
                200: '#fed7e2',
                300: '#fbb6ce',
                400: '#f687b3',
                500: '#ed64a6',
                600: '#d53f8c',
                700: '#b83280',
                800: '#97266d',
                900: '#702459',
            },
        },
        spacing: {
            px: '1px',
            0: '0',
            ...availableSizes,
        },
        /* We are using Bootstrap V4 screen dimensions */
        screens: {
            sm: '576px',
            md: '720px',
            lg: '960px',
            xl: '1140px',
        },
        fontFamily: {
            aroly: ['AROLY'],
            nunito: ['Nunito'],
            sans: [
                'Nunito',
                'Arial',
                'sans-serif',
            ],
            serif: ['serif'],
            mono: [
                'Menlo',
                'Monaco',
                'Consolas',
                '"Liberation Mono"',
                '"Courier New"',
                'monospace',
            ],
        },
        fontSize: {
            xs: '1.1rem',
            sm: '1.3rem',
            base: '1.6rem',
            md: '1.9rem',
            lg: '2.4rem',
            xl: '3.4rem',
            '2xl': '4.8rem',
            '3xl': '6.4rem',
            '4xl': '1.6rem',
            '5xl': '1.6rem',
        },
        fontWeight: {
            hairline: 100,
            thin: 200,
            light: 300,
            normal: 400,
            medium: 500,
            semibold: 600,
            bold: 700,
            extrabold: 800,
            black: 900,
        },
        lineHeight: {
            none: 1,
            tight: 1.25,
            snug: 1.375,
            normal: 1.5,
            relaxed: 1.625,
            loose: 2,
        },
        letterSpacing: {
            tight: '-.0618em',
            normal: '0',
            wide: '0.1em',
        },
        textColor: theme => theme('colors'),
        backgroundColor: theme => theme('colors'),
        backgroundPosition: {
            bottom: 'bottom',
            center: 'center',
            left: 'left',
            'left-bottom': 'left bottom',
            'left-top': 'left top',
            right: 'right',
            'right-bottom': 'right bottom',
            'right-top': 'right top',
            top: 'top',
        },
        backgroundSize: {
            auto: 'auto',
            cover: 'cover',
            contain: 'contain',
        },
        borderWidth: {
            default: '1px',
            0: '0',
            1: '1px',
            2: '2px',
            3: '3px',
            4: '4px',
            // '8': '8px',
        },
        borderColor: (theme) => { // eslint-disable-line arrow-body-style
            return global.Object.assign({ default: theme('colors.grey.300', 'currentColor') }, theme('colors')); // eslint-disable-line prefer-object-spread
        },
        borderRadius: {
            none: '0',
            sm: '0.4rem',
            default: '0.8rem',
            lg: '1.6rem',
            full: '9999px',
            inherit: 'inherit',
        },
        cursor: {
            auto: 'auto',
            default: 'default',
            pointer: 'pointer',
            wait: 'wait',
            move: 'move',
            'not-allowed': 'not-allowed',
        },
        width: theme => ({
            auto: 'auto',
            ...theme('spacing'),
            '1/2': '50%',
            '1/3': '33.33333%',
            '2/3': '66.66667%',
            '1/4': '25%',
            '3/4': '75%',
            '1/5': '20%',
            '2/5': '40%',
            '3/5': '60%',
            '4/5': '80%',
            '1/6': '16.66667%',
            '5/6': '83.33333%',
            full: '100%',
            screen: '100vw',
            'truncated-cell': '95%',
        }),
        height: theme => ({
            auto: 'auto',
            ...theme('spacing'),
            'row-sm': '4.0rem',
            row: '4.8rem',
            full: '100%',
            screen: '100vh',
            page: 'calc(100vh - 6.4rem)', // minus nav-topbar h-64
            'modal-full': 'calc(100vh - 5%)', // used to make modals full-screen minus some top/bottom margin
        }),
        minWidth: theme => ({
            0: '0',
            ...theme('spacing'),
            screen: '100vw',
            full: '100%',
        }),
        minHeight: theme => ({
            0: '0',
            ...theme('spacing'),
            'row-sm': '3.2rem',
            row: '4.8rem',
            full: '100%',
            screen: '100vh',
            page: 'calc(100vh - 6.4rem)', // minus nav-topbar h-64
        }),
        maxWidth: theme => ({
            // these should be setup to base16 scaling
            xs: '20rem',
            sm: '24rem',
            md: '28rem',
            lg: '32rem',
            xl: '36rem',
            '2xl': '42rem',
            '3xl': '48rem',
            '4xl': '56rem',
            '5xl': '64rem',
            '6xl': '72rem',
            full: '100%',
            ...theme('spacing'),
        }),
        maxHeight: theme => ({
            row: '4.8rem',
            full: '100%',
            screen: '100vh',
            page: 'calc(100vh - 6.4rem)', // minus nav-topbar h-64
            // 'localspark-page': 'calc(100vh - 6.4rem - 5.6rem)', // minus nav-topbar h-64, minus nav-localspark h-56
            ...theme('spacing'),
        }),
        padding: theme => theme('spacing'),
        margin: theme => ({ auto: 'auto', ...theme('spacing') }),
        negativeMargin: theme => theme('spacing'),
        objectPosition: {
            bottom: 'bottom',
            center: 'center',
            left: 'left',
            'left-bottom': 'left bottom',
            'left-top': 'left top',
            right: 'right',
            'right-bottom': 'right bottom',
            'right-top': 'right top',
            top: 'top',
        },
        boxShadow: {
            default: '0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06)',
            md: '0 4px 6px -1px rgba(0, 0, 0, .1), 0 2px 4px -1px rgba(0, 0, 0, .06)',
            lg: '0 10px 15px -3px rgba(0, 0, 0, .1), 0 4px 6px -2px rgba(0, 0, 0, .05)',
            'lg-primary': '0 15px 30px 0 rgba(238, 49, 80,0.24), 0 5px 15px 0 rgba(238, 49, 80,0.20)',
            'lg-secondary': '0 15px 30px 0 rgba(0,0,0,0.11), 0 5px 15px 0 rgba(0,0,0,0.08)',
            xl: '0 20px 25px -5px rgba(0, 0, 0, .1), 0 10px 10px -5px rgba(0, 0, 0, .04)',
            '2xl': '0 25px 50px -12px rgba(0, 0, 0, .25)',
            inner: 'inset 0 2px 4px 0 rgba(0,0,0,0.06)',
            outline: '0 0 0 3px rgba(66,153,225,0.5)',
            none: 'none',
        },
        zIndex: {
            auto: 'auto',
            '-10': -10,
            0: 0,
            10: 10,
            20: 20,
            30: 30,
            40: 40,
            50: 50,
        },
        opacity: {
            0: '0',
            25: '.25',
            33: '.333',
            50: '.5',
            66: '.666',
            75: '.75',
            100: '1',
        },
        fill: {
            current: 'currentColor',
        },
        stroke: {
            current: 'currentColor',
        },
        flex: {
            0: '0',
            1: '1',
            auto: '1 1 auto',
            initial: '0 1 auto',
            none: 'none',
        },
        flexGrow: {
            0: 0,
            default: 1,
        },
        flexShrink: {
            0: 0,
            default: 1,
        },
        listStyleType: {
            none: 'none',
            disc: 'disc',
            decimal: 'decimal',
        },
        inset: {
            0: 0,
            auto: 'auto',
        },
        container: {},
    },
    variants: {
        appearance: ['responsive'],
        backgroundAttachment: ['responsive'],
        backgroundColor: ['responsive', 'hover', 'focus', 'active'],
        backgroundPosition: ['responsive'],
        backgroundRepeat: ['responsive'],
        backgroundSize: ['responsive'],
        borderCollapse: [],
        borderColor: ['responsive', 'hover', 'focus'],
        borderRadius: ['responsive', 'hover'],
        borderStyle: ['responsive', 'hover'],
        borderWidth: ['responsive', 'hover'],
        cursor: ['responsive'],
        display: ['responsive'],
        flexDirection: ['responsive'],
        flexWrap: ['responsive'],
        alignItems: ['responsive'],
        alignSelf: ['responsive'],
        justifyContent: ['responsive'],
        alignContent: ['responsive'],
        flex: ['responsive'],
        flexGrow: ['responsive'],
        flexShrink: ['responsive'],
        float: ['responsive'],
        fontFamily: ['responsive'],
        fontWeight: ['responsive', 'hover', 'focus'],
        height: ['responsive'],
        lineHeight: ['responsive'],
        listStylePosition: ['responsive'],
        listStyleType: ['responsive'],
        margin: ['responsive'],
        maxHeight: ['responsive'],
        maxWidth: ['responsive'],
        minHeight: ['responsive'],
        minWidth: ['responsive'],
        negativeMargin: ['responsive'],
        objectFit: ['responsive'],
        objectPosition: ['responsive'],
        opacity: ['responsive', 'hover'],
        outline: ['focus', 'active'],
        overflow: ['responsive'],
        padding: ['responsive'],
        pointerEvents: ['responsive'],
        position: ['responsive'],
        inset: ['responsive'],
        resize: ['responsive'],
        boxShadow: ['responsive', 'hover', 'focus'],
        fill: [],
        stroke: [],
        tableLayout: ['responsive'],
        textAlign: ['responsive'],
        textColor: ['responsive', 'hover', 'focus', 'active'],
        fontSize: ['responsive'],
        fontStyle: ['responsive'],
        textTransform: ['responsive'],
        textDecoration: ['responsive', 'hover', 'focus'],
        fontSmoothing: ['responsive'],
        letterSpacing: ['responsive'],
        userSelect: ['responsive'],
        verticalAlign: ['responsive'],
        visibility: ['responsive'],
        whitespace: ['responsive'],
        wordBreak: ['responsive'],
        width: ['responsive'],
        zIndex: ['responsive'],
    },
    corePlugins: {
        container: false, // todo: explore this in the future
    },
    plugins: [
        ({ addUtilities }) => addUtilities({
            '.outline-pink-400': {
                // outline: 'none',
                outline: '1px solid',
                outlineColor: module.exports.theme.colors.pink[400],
                boxShadow: `0px 0px 8px 0px ${module.exports.theme.colors.pink[400]}`,
            },
        }),
    ],
};
