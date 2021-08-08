<template>
    <div>
        <button
            type="button"
            class="btn m-0 p-1 shadow-none"
        >

            <i class="fas fa-heart mr-1"
               :class="{'red-text' :this.isLikedBy , 'animated heartBeat fast':this.gotToLike}"
               @click="clickLike"
            />
        </button>
        {{ countLikes　}}
    </div>
</template>
<!--このファイルは単一ファイルコンポーネントとして扱われるのでtemplate、style、scriptを1つのVueファイルでまとめて管理する-->
<!--:classでv-bindを使用している。プロパティを直接使わない理由は値を変化させるため-->
<!--テンプレート内でv-on:ディレクティブ（@clickは省略形）を使うことでvueインスタンスのメソッドを呼び出すことができる-->
<!--animated heartBeat fastはいずれもbootstrapのclass属性　-->
<!--外部から参照されつことが前提なのでscriptの部分はexport default で囲むことが前提-->
<!--propsはプロパティ-->
<!--dataはオブジェクトを定義している。componentで必要な時にdata()を返すことができる。-->
<!--子のcomponentでは関数で返す必要がある。親componentに影響を与えないため-->
<!--asyncとawaitは、JavaScriptで非同期処理を簡潔に書くための仕組み-->
<!--非同期処理を伴う関数定義にasyncをつける。非同期処理を伴う関数実行時にawaitをつける。-->
<!--axiosはHTTP通信を行うためのJavaScriptのライブラリで
this.endpointはURIのarticles/{article}/likeに対して、HTTPのPUTメソッドでリクエストする-->
<!--const responseにはaxiosによるHTTP通信の結果が代入されて、response.dataとすることでレスポンスのボディ部にアクセスできる。
レスポンスのボディ部にはLaravel側のlikeやunlikeアクションメソッドの戻り値が代入されている。
なのでresponse.data.countLikesとすることで、いいね数を取得することができる。-->
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
            authorized: {
                type: Boolean,
                default: false,
            },
            endpoint: {
                type: String,
            },
        },

        data() {
            return {
                isLikedBy: this.initialIsLikedBy,
                countLikes: this.initialCountLikes,
                gotToLike: false,
            }
        },
        methods: {
            clickLike() {
                if(!this.authorized) {
                    alert('いいね機能はログイン中のみ使用できます')
                    return
                }

                this.isLikedBy
                ? this.unlike()
                : this.like()
            },

            async like() {
                const response = await axios.put(this.endpoint)
                this.isLikedBy = true
                this.countLikes = response.data.countLikes
                this.gotToLike = true
            },

            async unlike() {
                const response = await axios.delete(this.endpoint)
                this.isLikedBy = false
                this.countLikes = response.data.countLikes
                this.gotToLike = false
            },
        },
    }
</script>
