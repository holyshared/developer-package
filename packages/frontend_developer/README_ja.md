Frontend Developer Package 1.0b
===============================

Frontend Developer Packageは**小規模なオープンソースソフトウェア開発者向けのパッケージ**です。
主にフロントエンド開発者(HTML、CSS、javascript、Design)を対象にしています。
オープンソースソフトウェア開発者にとって、面倒なプロジェクトサイトをできるだけ早く公開できるような必要なブロック、テーマを含んでいます。
このパッケージを利用することにより、プロジェクトサイトをconcrete5で早く構築できるようになります。

**author** - [Noritaka Horio](http://sharedhat.com)
**licence** - [The MIT Licence](http://www.opensource.org/licenses/mit-license.php)
**contact** - [Contact](mailto:holy.shared.design@gmail.com)

インストールの仕方
--------------------------------

1. packagesディレクトリの下に解凍したフォルダをコピーします。
2. サイトにログインします。
3. 「機能を追加」メニューをクリックします。
4. 右下のインストール可能なパッケージから「Frontend Developer Package」のインストールボタンをクリックします。
5. 「新しいパッケージがインストールされました。」のメッセージが表示されれば、インストール完了です。


利用する前の設定
--------------------------------

このパッケージを利用する際に設定が必要です。
利用したいブロック、シングルページを確認して設定を行ってください。


### javascriptのアクセス許可

**Mootools Plugin Build Formブロック**を利用する場合、javascriptファイルのアクセスを許可する必要があります。
許可をしないと、githubのリポジトリからファイルマネージャにjavascriptファイルをインポートすることができません。
ですので、必ず許可を行うようにしてください。

#### 手順

1. ファイルマネージャメニューをクリックします。
2. アクセス権限をクリックします。
3. 許可されたファイル拡張子に「js」を追加します。
4. 入力した内容が表示されれば完了です。


### githubユーザー名の追加

**Mootools Plugin Build Form、Github Issues、Github Repository、Github Tagsブロック**を利用する場合、ユーザーの属性情報に
githubのユーザー名を入力する必要があります。
入力がない場合、チケット、タグ、リポジトリのリストをgithubのAPI経由で取得することができません。
ですので、必ず入力を行うようにしてください。



#### 手順

1. ユーザー・グループ管理をクリックします。
2. 一覧のユーザー名をクリックします。
3. 右上のユーザー編集をクリックします。
4. 一番下のgithubユーザー名をクリックします。
5. 入力欄にgithubユーザー名を入力します。
6. 右の編集アイコンをクリックし、内容を反映させます。
7. 入力した内容が表示されれば完了です。



ブロックについて
--------------------------------

このパッケージに含まれるのブロックの説明です。

### Mootools Plugin Build Form
mootools.netの[Core Builder](http://mootools.net/core)、[More Builder](http://mootools.net/more)のようなカスタマイズダウンロード可能なフォームを提供します。
また、ダウンロードの際の圧縮形式に、YUI Compressor、JSMin、無圧縮を選択できます。

### Github Issues
githubのチケットリストを表示します。
表示するチケット件数を指定できます。

### Github Repository
githubのリポジトリリストを表示します。
表示するリポジトリを指定できます。

### Github Tags
githubのタグリリストを表示します。
表示するタグの件数を指定できます。


テーマについて
--------------------------------

### Small Project

このパッケージ用に作成したテーマです。
ページタイプは下記をサポートしています。

#### ページタイプ

* 全幅表示
* 左ナビゲーション

デフォルトは左ナビゲーションです。

#### カスタムテンプレート

concrete5のデフォルトブロック用のカスタムテンプレートも含んでいます。

##### オートナビ

* **Small Project Topic Menu** - パンくずリスト用のテンプレート
* **Small Project Local Menu** - ローカルナビゲーション用のテンプレート
* **Small Project Header Menu** - ヘッダーナビゲーション用のテンプレート
* **Small Project Dooter Menu** - フッターナビゲーション用のテンプレート

##### コンテンツ

* **Small Project Module** - モジュール用のテンプレート
* **Small Project Line** - グリッド用のテンプレート

モジュール、グリッドに関しては、[oocss](http://wiki.github.com/stubbornella/oocss/)を参考にしてください。



#### tinymce用のコンテンツテンプレート

tinymceのプラグインにテンプレートというものがあります。
このプラグインは決まった書式の雛形を元に、エディタ内にコンテンツを挿入します。

このパッケージに含まれるテンプレートは下記の通りです。

* **module_lead** - ページの冒頭に記述するリード文テンプレート
* **module_default** - モジュールテンプレート
* **grid_5columns(20percent)** - 5カラムテンプレート
* **grid_3columns(33percent)** - 3カラムテンプレート
* **grid_2columns(50percent)** - 2カラムテンプレート


##### 設定例

1. サイトにログインします。
2. サイト全体の設定をクリックします。
3. 記事ブロックエディタの設定で「カスタム」をクリックします。
4. 入力欄にカスタム設定を記述します。

	**JS**
	//プラグインにtemplateを追加する
	plugins: "inlinepopups,spellchecker,safari,advlink,template",

	//ボタンにtemplateを追加する
	theme_concrete_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,hr,|,styleselect,formatselect,fontsizeselect,template",

	//テンプレートの設定ファイルのURLを指定する
	template_external_list_url: "/packages/frontend_developer/blocks/content/lists/template_list.js",

	//オプションの設定を追加する
	template_cdate_classes : "cdate creationdate",
	template_mdate_classes : "mdate modifieddate",
	template_selected_content_classes : "selcontent",
	template_cdate_format : "%m/%d/%Y : %H:%M:%S",
	template_mdate_format : "%m/%d/%Y : %H:%M:%S"



アンインストールの仕方
--------------------------------

1. サイトにログインします。
2. 「機能を追加」メニューをクリックします。
3. インストール済みパッケージに表示されている、Frontend Developer Packageの編集ボタンをクリックします。
4. 一番下の「パッケージを削除」をクリックします。
5. 確認画面の右下の「パッケージを削除」をクリックします。削除したくない場合はキャンセルをクリックしてください。
6. 「パッケージが削除されました。」のメッセージが表示されれば、アンインストール完了です。