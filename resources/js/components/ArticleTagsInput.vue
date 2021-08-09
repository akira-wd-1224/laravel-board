<template>
    <div>
<!--入力済みのタグ情報はvue上ではtagsに代入されるがHTMLとしてはspanタグ内に存在する。-->
<!--このままではformタグを使ってタグ情報をPOST送信することができない。-->
<!--コンポーネント内でtype属性にhiddenである隠しinputタグを作ることでタグに情報を持たせている-->
        <input
            type="hidden"
            name="tags"
            :value="tagsJson"
        >
<!--v-modelで双方向データバイディング-->
<!--プレースホルダとは、実際の内容を後から挿入するために、とりあえず仮に確保した場所のこと。
VueTagInputのプレイスホルダー(placeholder)は、デフォルトでは"Add Tag"。"タグを5個まで入力できます"にカスタマイズ-->
<!--:add-on-keyは確定キーをカスタマイズするために定義13はエンターキー32はスペースキー。番号はjsのキーコードで決められている-->
        <vue-tags-input
            v-model="tag"
            :tags="tags"
            placeholder="タグを5個まで入力できます"
            :autocomplete-items="filteredItems"
            :add-on-key="[13, 32, 229]"
            @tags-changed="newTags => tags = newTags"
        />
    </div>
</template>

<script>
import VueTagsInput from '@johmun/vue-tags-input';

export default {
    components: {
        VueTagsInput,
    },
    //Bladeから渡されたタグ情報は、プロパティinitialTagsで受け取る。
    props: {
        initialTags: {
            type: Array,
            default: [],
        },
        autocompleteItems: {
            type: Array,
            default: [],
        },
    },
    //プロパティinitialTagsの値をデータtagsの初期値としてセット
    data() {
        return {
            tag: '',
            tags: this.initialTags,
        };
    },
    //computedは算出プロパティ。結果がキャッシュされる
    computed: {
        filteredItems() {
            return this.autocompleteItems.filter(i => {
                return i.text.toLowerCase().indexOf(this.tag.toLowerCase()) !== -1;
            });
        },
        //データtagsをJSON形式の文字列に変換したものを返す
        tagsJson() {
            return JSON.stringify(this.tags)
        },
    },
};
</script>
<style lang="css" scoped>
.vue-tags-input {
    max-width: inherit;
}
</style>
<style lang="css">
.vue-tags-input .ti-tag {
    background: transparent;
    border: 1px solid #747373;
    color: #747373;
    margin-right: 4px;
    border-radius: 0px;
    font-size: 13px;
}
/*擬似要素"#"を付ける*/
.vue-tags-input .ti-tag::before {
    content: "#";
}
</style>
