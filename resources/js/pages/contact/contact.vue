<template>
    <div>
        contact

        <a
            class="Nav_icon"
            href="https://www.twitter.com/agm1984"
            rel="noopener noreferrer"
            target="_blank"
        >
            <svg
                x="0px"
                y="0px"
                width="16px"
                height="16px"
                viewBox="0 0 64 64"
                aria-labelledby="twitter-icon"
                role="img"
                xmlns="http://www.w3.org/2000/svg"
                xmlnsXlink="http://www.w3.org/1999/xlink"
            >
                <title id="twitter-icon">See Adam&apos;s Twitter</title>
                <path
                    id="twitter-icon"
                    fill="#fff"
                    d="M64,12.2c-2.4,1-4.9,1.8-7.5,2.1c2.7-1.6,4.8-4.2,5.8-7.3c-2.5,1.5-5.3,2.6-8.3,3.2C51.5,7.6,48.1,6,44.3,6 c-7.3,0-13.1,5.9-13.1,13.1c0,1,0.1,2,0.3,3C20.6,21.6,10.9,16.3,4.5,8.4c-1.1,1.9-1.8,4.2-1.8,6.6c0,4.6,2.3,8.6,5.8,10.9 c-2.2-0.1-4.2-0.7-5.9-1.6c0,0.1,0,0.1,0,0.2c0,6.4,4.5,11.7,10.5,12.9c-1.1,0.3-2.3,0.5-3.5,0.5c-0.8,0-1.7-0.1-2.5-0.2 c1.7,5.2,6.5,9,12.3,9.1c-4.5,3.5-10.2,5.6-16.3,5.6c-1.1,0-2.1-0.1-3.1-0.2C5.8,55.8,12.7,58,20.1,58c24.2,0,37.4-20,37.4-37.4 c0-0.6,0-1.1,0-1.7C60,17.1,62.2,14.8,64,12.2z"
                />
            </svg>
        </a>

        <a
            class="Nav_icon"
            href="https://www.medium.com/@agm1984"
            rel="noopener noreferrer"
            target="_blank"
        >
            <svg
                x="0px"
                y="0px"
                width="16px"
                height="16px"
                viewBox="0 0 24 24"
                aria-labelledby="medium-icon"
                role="img"
                xmlns="http://www.w3.org/2000/svg"
                xmlnsXlink="http://www.w3.org/1999/xlink"
            >
                <title id="medium-icon">See Adam&apos;s Medium</title>
                <path
                    id="medium-icon"
                    fill="#fff"
                    d="M2.846 6.36c.03-.295-.083-.586-.303-.784l-2.24-2.7v-.403H7.26l5.378 11.795 4.728-11.795H24v.403l-1.917 1.837c-.165.126-.247.333-.213.538v13.5c-.034.204.048.41.213.537l1.87 1.837v.403h-9.41v-.403l1.937-1.882c.19-.19.19-.246.19-.538V7.794l-5.39 13.688h-.727L4.278 7.794v9.174c-.052.386.076.774.347 1.053l2.52 3.06v.402H0v-.403l2.52-3.06c.27-.278.39-.67.326-1.052V6.36z"
                />
            </svg>
        </a>

        <a
            class="Nav_icon"
            href="https://www.github.com/agm1984"
            rel="noopener noreferrer"
            target="_blank"
        >
            <svg
                x="0px"
                y="0px"
                width="16px"
                height="16px"
                viewBox="0 0 24 24"
                aria-labelledby="github-icon"
                role="img"
                xmlns="http://www.w3.org/2000/svg"
                xmlnsXlink="http://www.w3.org/1999/xlink"
            >
                <title>See Adam&apos;s GitHub</title>
                <path
                    id="github-icon"
                    fill="#fff"
                    d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"
                />
            </svg>
        </a>
    </div>
</template>

<script>
export default {
    name: 'contact',

    metaInfo() {
        return { title: 'Contact' };
    },

    data() {
        return {};
    },

    computed: {},

    methods: {},

};
</script>

<style>
 #Nav_social {
    flex: 0;
    display: flex;
    flex-direction: row;
    width: 19.2rem;
    padding: 3.2rem 3.2rem 3.2rem 0;
}

    .Nav_icon {
    padding-left: 3.2rem;
}

    #Nav_social svg #twitter-icon,
    #Nav_social svg #medium-icon,
    #Nav_social svg #github-icon {
    transition: all 200ms ease-in-out;
}

    #Nav_social svg:hover #twitter-icon,
    #Nav_social svg:hover #medium-icon,
    #Nav_social svg:hover #github-icon {
    fill: #66FCF1;
    transition: all 250ms ease-in-out;
}

    #Nav_social svg:active #twitter-icon,
    #Nav_social svg:active #medium-icon,
    #Nav_social svg:active #github-icon {
    fill: #45A29E;
    width: 50px;
    height: 100px;
}
</style>
