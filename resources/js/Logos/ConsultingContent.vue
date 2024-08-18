<script setup>
    const props = defineProps({
        pdfUrl: String,
    })
</script>
<template>
    <div>
        <iframe :src="pdfUrl" width="100%" height="600px"></iframe>
    </div>
    <!-- <object :data="pdfUrl" type="application/pdf" width="600px" height="100%">
        <p>Your browser does not support PDFs. Download the PDF to view it: <a :href="pdfUrl">Download PDF</a>.</p>
    </object> -->
    ____
</template>