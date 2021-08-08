<template>
    <div>
        <button
            type="button"
            class="btn m-0 p-1 shadow-none"
        >
            <i class="fas fa-heart mr-1"
               :class="{'red-text' :this.isLikedBy}"
            />
        </button>
        {{ countLikes　}}
    </div>
</template>
<!--このファイルは単一ファイルコンポーネントとして扱われるのでtemplate、style、scriptを1つのVueファイルでまとめて管理する-->
<!--外部から参照されつことが前提なのでscriptの部分はexport default で囲むことが前提-->
<!--propsはプロパティ-->
<!--dataはオブジェクトを定義している。componentで必要な時にdata()を返すことができる。子のcomponentでは関数で返す必要がある-->
<!--プロパティを直接使わない理由は値を変化させるため-->
<script>
    export default {
        props: {
            initialIsLikedBy: {
                type: Boolean,
                default: false,
            },
            initialCountLikes: {
                type: Number,
                default: 0,
            },
        },
        data() {
            return {
                isLikedBy: this.initialIsLikedBy,
                countLikes: this.initialCountLikes,
            }
        },
    }
</script>
