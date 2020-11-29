<template>
    <div class="flex w-full h-auto xl:w-1024">
        <div class="flex flex-col w-full xl:flex-row">
            <a-card class="order-1 w-full p-32 mr-0 xl:mr-16" with-geometry>
                <a-heading level="1" class="mb-16">Contact</a-heading>

                <a-paragraph>
                    Ready to get in touch?
                </a-paragraph>

                <a-paragraph>
                    Send a message here, or email me at <a :href="`mailto:${myEmail}`">{{ myEmail }}</a>
                    <span
                        v-if="isDisplayingSuccessMessage"
                        class="text-sm"
                    >
                        Copied to Clipboard
                        <span class="text-mint-hover">✓</span>
                    </span>

                    <button
                        v-else
                        class="text-sm"
                        tabindex="0"
                        title="Copy email address into clipboard"
                        @click="copyEmailToClipboard"
                    >
                        Copy to Clipboard
                    </button>
                </a-paragraph>

                <div class="flex flex-col pb-8 bg-grey-200">
                    <a-heading level="4" class="px-16 py-8 bg-primary" nunito light>
                        Find me on social media
                    </a-heading>
                    <a-social-link class="pt-8 pl-16" network="twitter">Twitter</a-social-link>
                    <a-social-link class="pt-8 pl-16" network="github">GitHub</a-social-link>
                    <a-social-link class="pt-8 pl-16" network="stackoverflow">StackOverflow</a-social-link>
                    <a-social-link class="pt-8 pl-16" network="medium">Medium</a-social-link>
                </div>
            </a-card>

            <a-form v-slot="{ handleSubmit }" class="flex flex-col order-2 w-full mt-64 ml-0 xl:ml-16 xl:mt-0">
                <a-text-input
                    v-model="message.sender_name"
                    class="mb-20"
                    rules="required"
                    vid="sender_name"
                    placeholder="Name"
                ></a-text-input>

                <a-text-input
                    v-model="message.sender_email"
                    class="mb-20"
                    rules="required"
                    vid="sender_email"
                    placeholder="Email"
                ></a-text-input>

                <a-text-input
                    v-model="message.subject"
                    class="mb-20"
                    rules="required"
                    vid="subject"
                    placeholder="Subject"
                ></a-text-input>

                <a-text-input
                    v-model="message.content"
                    rules="required"
                    vid="content"
                    type="textarea"
                    placeholder="Type your message here"
                    maxlength="2000"
                    has-counter
                ></a-text-input>

                <div class="flex flex-row items-center justify-end">
                    <span class="mr-8">
                        {{ verificationText }}
                    </span>

                    <a-text-input
                        v-model="message.answer"
                        class="mr-8 w-80"
                        rules="required"
                        vid="answer"
                    ></a-text-input>

                    <a-button
                        native-type="submit"
                        :disabled="!isFormVerified"
                        style="margin-top: -0.2rem;"
                        expanded
                        @click="handleSubmit(sendMessage)"
                    >
                        SEND
                    </a-button>
                </div>
            </a-form>
        </div>

    </div>
</template>

<script>
const INITIAL = 0;
const IS_DISPLAYING_SUCCESS_MESSAGE = 1;

/**
 * Creates a random number used for creation of mathematical solutions
 * that are used for a human verification step before submitting.
 */
const generateRandom = () => Math.floor((Math.random() * 10) + 1);

export default {
    name: 'contact',

    metaInfo() {
        return { title: 'Contact' };
    },

    data() {
        return {
            state: INITIAL,
            myEmail: 'adam@adammackintosh.net',
            num1: generateRandom(),
            num2: generateRandom(),
            message: {
                subject: '',
                content: '',
                sender_name: '',
                sender_email: '',
                answer: '',
            },
            isFormVerified: false,
        };
    },

    computed: {
        isInitial() {
            return (this.state === INITIAL);
        },

        isDisplayingSuccessMessage() {
            return (this.state === IS_DISPLAYING_SUCCESS_MESSAGE);
        },

        messageAnswer() {
            return +this.message.answer;
        },

        verificationText() {
            return `${this.num1} + ${this.num2} =`;
        },

    },

    watch: {
        messageAnswer() {
            const solution = (this.num1 + this.num2);
            if (this.messageAnswer === solution) {
                this.isFormVerified = true;
                return;
            }
            this.isFormVerified = false;
        },
    },

    methods: {
        copyEmailToClipboard() {
            const textField = document.createElement('textarea');

            textField.innerText = this.myEmail;
            document.body.appendChild(textField);
            textField.select();
            document.execCommand('copy');
            textField.remove();

            if (this.isDisplayingSuccessMessage) return undefined;

            this.state = IS_DISPLAYING_SUCCESS_MESSAGE;

            return setTimeout(() => {
                this.state = INITIAL;
            }, 1618);
        },

        async sendMessage() {
            try {
                console.log('FORM SENT');
            } catch (err) {
                throw new Error(`contact# Problem submitting contact form: ${err}.`);
            }
        },

    },

};
</script>
