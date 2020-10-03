<template>
    <a-page v-title="'Contact'">
        <div id="contact_form-wrapper">
            <div id="contact_form">
                <div id="contact_left">
                    <a-sacred-geometry
                        circleColor="#FF5043"
                        dotColor="#339999"
                        lineColor="#C5C6C7"
                        :extraStyles="{
                            position: 'absolute',
                            top: 0,
                            left: 0,
                            width: '100%',
                            height: '100%',
                            opacity: 0.2,
                            zIndex: 0,
                        }"
                    ></a-sacred-geometry>

                    <h1>contact</h1>

                    <p>Ready to get in touch?</p>

                    <p>Send a message here, or email me at {{ myEmail }}</p>

                    <div
                        v-if="isDisplayingSuccessMessage"
                        id="contact_clipboard-success"
                    >
                        COPIED TO CLIPBOARD
                        <span>✓</span>
                    </div>

                    <button
                        v-else
                        id="contact_clipboard"
                        tabindex="0"
                        @click="copyEmailToClipboard"
                    >
                        COPY TO CLIPBOARD
                    </button>

                    <div id="contact_reasons-wrapper">
                        <p>I especially enjoy working with people who:</p>

                        <ul id="contact_reasons">
                            <li>have clear goals</li>
                            <li>maintain a growth mindset</li>
                            <li>value precision &amp; thoroughness</li>
                        </ul>
                    </div>

                    <div id="contact_form-line"></div>
                </div>

                <div id="contact_right">
                    <a-form v-slot="{ handleSubmit }">
                        <a-text-input
                            v-model="message.sender_name"
                            rules="required"
                            vid="sender_name"
                            label="Name"
                            placeholder="Name"
                        ></a-text-input>

                        <a-text-input
                            v-model="message.sender_email"
                            rules="required"
                            vid="sender_email"
                            label="Email"
                            placeholder="Email"
                        ></a-text-input>

                        <a-text-input
                            v-model="message.subject"
                            rules="required"
                            vid="subject"
                            label="Subject"
                            placeholder="Subject"
                        ></a-text-input>

                        <a-text-input
                            v-model="message.content"
                            rules="required"
                            vid="content"
                            type="textarea"
                            label="Content"
                            placeholder="Type your message here"
                            maxlength="2000"
                            has-counter
                        ></a-text-input>

                        <div id="contactForm_finalRow">
                            <div id="contactForm_finalRow-left">
                                <div className="contact_form_verification-question">
                                    {{ verificationText }}
                                </div>

                                <div className="contact_input-divider"></div>

                                <div className="contact_form_verification-solution">
                                    <a-text-input
                                        v-model="message.answer"
                                        rules="required"
                                        vid="answer"
                                    ></a-text-input>
                                </div>

                                <div className="contact_input-divider lastDivider"></div>
                            </div>

                            <div id="contactForm_finalRow-right">
                                <button
                                    type="submit"
                                    :class="isFormVerified ? 'contact_submit-ready' : 'contact_submit-default'"
                                    href="#contact_message"
                                    @click="handleSubmit(handleMessageSend)"
                                >
                                    SEND
                                </button>
                            </div>
                        </div>
                    </a-form>
                </div>
            </div>
        </div>

    </a-page>
</template>

<script>
const INITIAL = 0;
const IS_DISPLAYING_SUCCESS_MESSAGE = 1;

/**
 * Creates a random number used for creation of mathematical solutions
 * that are used for a human verification step before submitting.
 */
const generateRandom = () => Math.floor((Math.random() * 10) + 1)

export default {
    name: 'contact',

    props: {},

    data() {
        return {
            state: INITIAL,
            myEmail: 'adam@adammackintosh.net',
            num1: generateRandom(),
            num2: generateRandom(),
            isFormVerified: false,
            message: {
                subject: '',
                content: '',
                sender_name: '',
                sender_email: '',
                answer: '',
            },
        };
    },

    computed: {
        isInitial() {
            return (this.state === INITIAL);
        },

        isDisplayingSuccessMessage() {
            return (this.state === IS_DISPLAYING_SUCCESS_MESSAGE);
        },

        verificationText() {
            return `${this.num1} + ${this.num2} =`;
        },

    },

    mounted() {},

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

        async handleMessageSend() {
            try {

            } catch (err) {
                throw new Error(`contact# Problem submitting contact form: ${err}.`);
            }
        },

    },

};
</script>

<style>
#contact {
    min-height: 100vh;
}

#contact_form-wrapper {
    position: absolute;
    top: 0;
    left: 0;
    display: flex;
    justify-content: center;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.1);
}

#contact_form {
    display: flex;
    width: 100%;
}

#contact_left {
    position: relative;
    width: 50%;
    min-height: 48.0rem;
    background: #383838;
    border: 0.2rem solid #fff;
    padding: 3.2rem;
    margin: 0 3.2rem 4.6rem 6.4rem;
    text-align: center;
    z-index: 0;
}

#contact_left h1 {
    position: relative;
    font-family: 'AROLY', sans-serif;
    font-size: 3.2rem;
    line-height: 3.2rem;
    letter-spacing: 0.1em;
    color: #FF5043;
    margin: 0;
    padding-bottom: 3.2rem;
}

#contact_left p {
    position: relative;
    font-family: 'Roboto', sans-serif;
    letter-spacing: 0.1rem;
    font-weight: 300;
    font-size: 1.6rem;
    line-height: 2.4rem;
    margin: 0;
    padding-bottom: 1.6rem;
}

#contact_clipboard {
    position: relative;
    font-family: 'Oswald', sans-serif;
    font-weight: 200;
    font-size: 1.0rem;
    line-height: 1.0rem;
    letter-spacing: 0.2em;
    color: #fff;
    background: none;
    margin-bottom: 1.6rem;
    padding: 0.8rem 0.8rem 0.8rem 0.8rem;
    border: 0.1rem solid #fff;
    transition: all 250ms ease-in-out;
    z-index: 1;
}

#contact_clipboard:hover {
    color: #66FCF1;
    border: 0.1rem solid #66FCF1;
    transition: all 250ms ease-in-out;
}

#contact_clipboard:active {
    color: #FF5043;
    border: 0.1rem solid #FF5043;
}

#contact_clipboard-success {
    position: relative;
    font-family: 'Oswald', sans-serif;
    font-weight: 200;
    font-size: 1.0rem;
    line-height: 1.0rem;
    letter-spacing: 0.2em;
    color: #fff;
    outline: none;
    background: none;
    margin-top: 0.1rem;
    margin-right: 1.1rem;
    margin-bottom: 1.8rem;
    padding: 0.8rem 0.8rem 0.7rem 0.8rem;
    transition: all 250ms ease-in-out;
}

#contact_clipboard-success span {
    position: absolute;
    top: 0;
    font-size: 2.4rem;
    color: lightgreen;
    margin-top: 0.4rem;
    padding-left: 0.8rem;
}

#contact_form-line {
    position: absolute;
    display: inline-block;
    top: 2.8rem;
    right: -3.2rem;
    width: 6.4rem;
    height: 0.4rem;
    background-color: #fff;
}

#contact_reasons-wrapper {
    flex: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
}

#contact_reasons {
    position: relative;
    display: flex;
    flex-direction: column;
    list-style-type: none;
    margin: 0;
    padding: 0;
    margin-top: -0.4rem;
}

#contact_reasons li {
    font-family: 'Roboto', sans-serif;
    letter-spacing: 0.1rem;
    font-weight: 300;
    font-size: 1.6rem;
    line-height: 2.2rem;
    text-align: left;
    margin: 0;
}

#contact_reasons li:before {
    content: '△';
    color: #66FCF1;
    padding-right: 0.8rem;
}

#contact_right {
    width: 50%;
    padding: 0 6.4rem 0 3.2rem;
}

#contact_form-wrapper {
    display: flex;
    flex-direction: column;
    width: 100%;
}

.contact_form-splitter {
display: flex;
flex-direction: row;
flex-wrap: nowrap;
justify-content: flex-end;
width: 100%;
}

.contact_input-half {
    width: 50%;
    text-align: right;
}

.contact_input-divider {
    width: 6.4rem;
}

.contact_form_verification-question {
    font-family: 'Oswald', sans-serif;
    font-weight: 200;
    font-size: 2.2rem;
    line-height: 2.2rem;
    letter-spacing: 0.23em;
    padding-top: 2.1rem;
    margin-right: -4.8rem;
    white-space: nowrap;
}

.contact_form_verification-solution {
    width: 6.4rem;
    font-family: 'Oswald', sans-serif;
    font-weight: 200;
    font-size: 2.2rem;
    line-height: 2.2rem;
    letter-spacing: 0.23em;
    text-align: center;
}

.contact_verification-fail {
    border: 0.2rem solid #A11A23;
    background-color: #eabea9;
    color: #A11A23;
    transition: all 250ms ease-in-out;
}

.contact_verification-fail:focus {
    border: 0.2rem solid #A11A23;
}

.contact_verification-pass {
    background: rgba(255, 255, 255, 0.809);
    border: 0.2rem solid #228b44;
    transition: all 250ms ease-in-out;
}

#contactForm_finalRow {
    display: flex;
    flex-direction: row;
    width: 100%;
}

#contactForm_finalRow-left {
    display: flex;
    flex-direction: row;
    justify-content: flex-end;
    flex: 1;
}

#contactForm_finalRow-right {
    flex: 0;
}

.contact_submit-default {
    height: 6.4rem;
    font-family: 'Oswald', sans-serif;
    font-size: 1.6rem;
    line-height: 1.6rem;
    font-weight: 400;
    letter-spacing: 0.2em;
    background: none;
    color: #CCCCCC;
    border: 0.2rem solid #CCCCCC;
    transition: all 250ms ease-in-out;
    padding: 1.6rem;
    padding-left: 6.4rem;
    padding-right: 6.4rem;
    white-space: nowrap;
}

.contact_submit-ready {
    height: 6.4rem;
    font-family: 'Oswald', sans-serif;
    font-size: 1.6rem;
    line-height: 1.6rem;
    font-weight: 400;
    letter-spacing: 0.2em;
    background: #66FCF1;
    border: 0.2rem solid #66FCF1;
    color: #212121;
    padding: 1.6rem;
    padding-left: 6.4rem;
    padding-right: 6.4rem;
    white-space: nowrap;
}

.contact_submit-ready:hover {
    background: none;
    border: 0.2rem solid #66FCF1;
    color: #66FCF1;
    transition: all 250ms ease-in-out;
}

.contact_submit-ready:active {
    font-weight: 400;
    background: #fff;
    border: 0.2rem solid #fff;
    color: #212121;
}

@media (max-width: 1024px) {
    #contact_form {
        flex-direction: column;
        align-items: center;
        padding-top: 22.4rem;
    }
    #contact_form-line {
        top: initial;
        bottom: -3.2rem;
        left: calc(50% - 0.4rem);
        width: 0.4rem;
        height: 6.4rem;
    }
    #contact_left {
        width: 64.0rem;
        height: 100%;
        margin: 0 0 6.4rem 0;
        padding-bottom: 6.4rem;
    }
    #contact_right {
        width: 64.0rem;
        height: 100%;
        padding: 0;
    }
}

@media (max-width: 800px) {
    #contact_form {
        padding-left: 3.2rem;
        padding-right: 3.2rem;
    }
    #contact_left {
        width: 100%;
    }
    #contact_right {
        width: 100%;
    }
}

@media (max-width: 600px) {
    #contact_left {
        width: 32.0rem;
    }
    #contact_right {
        width: 32.0rem;
    }
    #contactForm_finalRow {
        flex-direction: column;
        height: 100%;
        padding-bottom: 6.4rem;
    }
    #contactForm_finalRow-left {
        display: flex;
        justify-content: center;
        height: 6.4rem;
        margin-bottom: 6.4rem;
    }
    .lastDivider {
        display: none;
    }
    #contactForm_finalRow-right {
        display: flex;
        justify-content: center;
    }
}
</style>
