<template>
    <div>
        <button
            class="btn-sm shadow-none border border-primary p-2"
            :class="buttonColor"
        >
            <i
                class="mr-1"
                :class="buttonIcon"
            ></i>
            {{ buttonText }}
        </button>
    </div>
</template>

<script>
    export default {
        props: {
            initialIsFollowedBy: {
                type: Boolean,
                default: false,
            }
        },
        //データisFollowdByで、このボタンを表示しているユーザーページのユーザーを、
        //ログイン中のユーザーがフォローしているのか、フォローしていないのかを管理
        data() {
            return {
                isFollowedBy: this.initialIsFollowedBy,
            }
        },
        computed: {
            buttonColor() {
                return this.isFollowedBy
                    ? 'bg-primary text-white'
                    : 'bg-white'
            },
            buttonIcon() {
                return this.isFollowedBy
                    ? 'fas fa-user-check'
                    : 'fas fa-user-plus'
            },
            buttonText() {
                return this.isFollowedBy
                    ? 'フォロー中'
                    : 'フォロー'
            },
        },
    }
</script>
