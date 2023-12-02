<template>
    <div>
        <v-row class="justify-content-center">
            <v-col cols="12" md="6">
                <img
                    src="{{ asset('storage/user_avatar/' . Auth::user()->avatar) }}"
                    alt=""
                    class="avatar-img mx-auto d-block"
                />
            </v-col>
        </v-row>
    </div>
</template>

<script>
export default {};
</script>
