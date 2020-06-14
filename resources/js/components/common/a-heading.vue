<script>
export default {
    name: 'a-heading',

    functional: true,

    props: {
        level: {
            type: [Number, String],
            required: false,
            default: () => 2,
        },

        light: {
            type: Boolean,
            required: false,
            default: () => true,
        },

        dark: {
            type: Boolean,
            required: false,
            default: () => false,
        },

        oswald: {
            type: Boolean,
            required: false,
            default: () => false,
        },

        inline: {
            type: Boolean,
            required: false,
            default: () => false,
        },
    },

    data() {
        return {};
    },

    render(h, ctx) {
        const { props, attrs, listeners } = ctx;

        const Heading = `h${props.level}`;

        const getStylesForHeadingLevel = ({ level, dark, light, oswald, inline }) => {
            const styles = [''];

            if (inline) styles.push('inline tracking-wide');

            if (+level === 1) styles.push('text-xl');
            if (+level === 2) styles.push('text-lg');
            if (+level === 3) styles.push('text-md');
            if (+level === 4) styles.push('text-base');
            if (+level === 5) styles.push('text-sm');
            if (+level === 6) styles.push('text-xs');

            if (oswald) styles.push('oswald');
            else styles.push('font-aroly');

            // text colour
            if (light) styles.push('text-white');
            else if (dark) styles.push('text-black');

            return styles;
        };

        return (
            <Heading
                class={[...getStylesForHeadingLevel(props), ctx.data.staticClass]}
                style={ctx.data.staticStyle}
                {...{ on: listeners }}
                {...attrs}
            >
                {ctx.slots().default}
            </Heading>
        );
    },
};
</script>
