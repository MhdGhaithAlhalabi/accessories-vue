<template>
    <Link
        class="nav-link"
        :class="{'active' : active}"
    >
        <slot name="ico"></slot>

        <p>
            <slot/>
        </p>
    </Link>
</template>
<script>
export default {
    props: {
        active: Boolean
    }
}
</script>
