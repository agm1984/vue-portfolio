<script setup>
</script>

<template>
    <footer class="w-full flex flex-col bg-grey-800 text-grey-200 px-8 pb-8">
        <div class="flex justify-center">△△△</div>

        <a-testimonials
            class="mt-8"
            :testimonials="testimonials"
            :interval="5000"
            auto-play
        ></a-testimonials>

        <div class="text-center mt-8">
            <p>&copy; {{ new Date().getFullYear() }} Adam Mackintosh. All rights reserved.</p>
        </div>
    </footer>
</template>
