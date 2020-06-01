<template>
    <div class="flex flex-col w-full h-auto">
        <!-- eslint-disable vue/html-indent-->
        <a-code language="css" highlight-line="7,14, 20-24">
            pre[class*="language-"]::-moz-selection, pre[class*="language-"] ::-moz-selection,
            code[class*="language-"]::-moz-selection, code[class*="language-"] ::-moz-selection {
                text-shadow: none;
                background: #004a9e;
            }

            pre[class*="language-"]::selection, pre[class*="language-"] ::selection,
            code[class*="language-"]::selection, code[class*="language-"] ::selection {
                text-shadow: none;
                background: #004a9e;
            }

            /* Code blocks */
            pre[class*="language-"] {
                padding: 1em;
                margin: .5em 0;
                overflow: auto;
            }

            /* Inline code */
            :not(pre) > code[class*="language-"] {
                padding: .1em;
                border-radius: .3em;
            }
        </a-code>

        <a-code id="anchor-test-1" language="php" has-line-numbers highlight-line="5-8">
            use App\Test;
            use Thing;

            /**
             * Send the token to Vue after the user authenticates.
             *
             * @param \Illuminate\Http\Request $request
             * @return \Illuminate\Http\JsonResponse
             */
            protected function sendLoginResponse(Request $request)
            {
                $this->clearLoginAttempts($request);

                $user = $this->guard()->user();
                $token = (string)$this->guard()->getToken();

                return response()->json([
                    'user' => $user,
                    'token' => $token,
                ]);
            }
        </a-code>

        <a-heading level="2">
            Parse a JSON Web Token (JWT)
        </a-heading>

        We might have some text around here. We might have some text around here. We might have some text around here.

        <a-code language="javascript" is-fancy>
            /**
             * Decodes a JSON Web Token.
             *
             * @param {String} token
             * @return {Object}
             */
            const parseJwt = (token) => {
                try {
                    if (!token) {
                        throw new Error('parseJwt# Token is required.');
                    }

                    const base64Payload = token.split('.')[1];
                    let payload = new Uint8Array();

                    try {
                        payload = Buffer.from(base64Payload, 'base64');
                    } catch (err) {
                        throw new Error(`parseJwt# Malformed token: ${err}`);
                    }

                    return {
                        decodedToken: JSON.parse(payload),
                    };
                } catch (err) {
                    console.log(`parseJwt# Bonus logging: ${err}`);

                    return {
                        error: 'Unable to decode token.',
                    };
                }
            };
        </a-code>

        <a-code language="javascript">
            {{ sourcecode }}
        </a-code>

        <a-code language="javascript" is-fancy>
            {{ sourcecode }}
        </a-code>

        <a-code language="javascript">
            let isPalindrome = (word) => {
                let [length, result] = [word.length, true];

                for (let i = 0; i &lt; length / 2; i++) {
                    if (word[i] !== word[length - 1 - i]) result = false;
                }

                return result;
            }

            module.exports = isPalindrome;
        </a-code>

        <a-code language="javascript" has-line-numbers>
            let isPalindrome = (word) => {
                let [length, result] = [word.length, true];

                for (let i = 0; i &lt; length / 2; i++) {
                    if (word[i] !== word[length - 1 - i]) result = false;
                }

                return result;
            }

            module.exports = isPalindrome;
        </a-code>

        <a-code highlight-line="2-4">
            // misc language
            call.thing('prop')

            public static function (Yolo $true) : void
            {
                return '';
            }

            int main;
        </a-code>

        <a-code is-fancy>
            // misc language
            call.thing('prop')

            // note: https://www.com
            public static function (Yolo $true) : void
            {
                return '';
            }

            int main;
        </a-code>

        <a-code id="anchor-test-2" has-line-numbers highlight-line="5-8">
            // misc language
            call.thing('prop')

            public static function getEmptyString(Yolo $yolo) : Yolo
            {
                return $yolo;
            }

            int main;
        </a-code>

        <a-paragraph>
            But what would happen if we added tons more? da <a-code inline>const test = 'test';</a-code>
            success. But what would happen if we added tons more? But what would happen if we added tons more?
            But what would happen if we added tons more? But what would happen if we added tons more?
            But what would happen if we added tons more? asd <a-code inline>ui = fn(state)</a-code>.
            But what would happen if we added tons more? If we added tons more?
            <a-code inline>smallpox</a-code>.
        </a-paragraph>

        <a-paragraph>
           ld happen if we added tons more? But what would happen if we added tons more? But what would happen if
            <a-code inline>const prettyLongOneToTestWith = 'radical-length-oh-no';</a-code> success.
            But what would happen if we added tons more? But what would happen if we added tons more?
            But what would happen if we added tons more? But what would happen if we added tons more?
            But what would happen if we added tons more? <a-code inline>ui = fn(state)</a-code>.
            But what would happen if we added tons more? If we added tons more?
            <a-code inline>smallpox</a-code>.
        </a-paragraph>

    </div>
</template>

<script>
export default {
    name: 'snippets',

    data() {
        return {
            sourcecode: "const test = 'asdf';",
        };
    },

    computed: {},

    mounted() {},

    methods: {},

};
</script>
