# Kotatsu
ユーザーが匿名でテキストや画像を投稿できるイメージボードWEBアプリです。  
アプリ名の「Kotatsu」は、1つの話題に対してみんながコメントし合えるような雰囲気を表現しています。

## URL
https://kotatsu.yuki-gakiya.com

## Demo


## 概要
Kotatsuはテキストや画像を投稿できるイメージボードWEBアプリケーションです。  
ユーザーはテキストのみ、あるいはテキストと画像を組み合わせてスレッドを作成することができます。  
スレッドが作成されると、他のユーザーはテキストや画像を使用して返信できます。スレッドやコメントなどの投稿はすべて匿名です。

## 主な機能
### スレッドの閲覧
トップページでは、新しい順に最大200個のスレッドを閲覧できます。  
各スレッドでは最大5つのコメントが表示され、コメントが6つ以上ある場合は「すべてのコメント」をクリックすることで、スレッドのページに移動し、全てのコメントを見ることができます。また、スレッドや「返信」のアイコンをクリックすると、直接スレッドのページにアクセスできます。  


### スレッドの投稿
スレッドは[kotatsu.yuki-gakiya.com/submit](https://kotatsu.yuki-gakiya.com/submit)のページから投稿できます。このページは、ナビバーの「New」またはトップページの「今日何かあった？」からアクセスできます。  
スレッドの投稿フォームでは、タイトル、本文、および画像を入力できます。タイトルと画像は任意ですが、本文は必須です。  

スレッドの投稿には以下の条件があり、これらの条件を満たさない場合はアラートが表示されます。

- タイトル: 300文字以内
- 本文: 1文字以上～40,000文字以内
- 画像: 拡張子はjpeg, png, gifのみ。サイズは5MB以内

作成ボタンをクリックすると、一意のURLが作成され、スレッドが表示されます。

### スレッドへのコメント
スレッドのページからコメントを投稿できます。コメントもスレッドと同様に、タイトルと画像は任意で、本文は必須です。  
コメントの投稿には以下の条件があり、これらの条件を満たさない場合はアラートが表示されます。コメントを投稿すると、スレッドのページで即座に表示されます。 

- タイトル: 300文字以内
- 本文: 1文字以上～10,000文字以内
- 画像: 拡張子はjpeg, png, gifのみ。サイズは5MB以内


## 機能一覧
- スレッドの作成
- スレッドへの返信
- スレッドと返信の表示
- URL作成
- 画像アップロード
- 相対的な日付表示
- サムネイルの表示
- エラーハンドリング

## 作成の経緯
Kotatsuを開発した主な目的は、DAO（データアクセスオブジェクト）を活用したWEBアプリケーションを構築することです。  
過去には、3層アーキテクチャを学習する一環としてテキスト共有アプリ「Text Snippetter」と、画像共有アプリ「Pix Pocket」を開発しました。  
これらのプロジェクトでは、クエリの実行を担当するDatabaseHelperクラスを作成し、データベースへのアクセスにはmysqliネイティブライブラリを用いてMySQLにクエリを実行していました。  これにより、ルーティングから直接クエリを実行するのではなく、関心の分離と可読性を高めました。

当プロジェクトでは、DatabaseHelperクラスではなくDAOの効果的な利用に焦点を当て、データ層をより抽象化することを目指しました。    
Text SnippetterやPix Pocket同様に、以下の技術を組み合わせて活用し、より強固でセキュアなWEBアプリケーションの構築を目指しています。

- マイグレーションベースのスキーマ管理
- バックエンドからのデータベース操作
- SQLインジェクション対策
- サーバーサイドレンダリング
- 3層アーキテクチャ


## 使用技術

### フロントエンド
| 項目                | 内容                         |
|---------------------|------------------------------|
| 使用言語            | HTML, CSS, Javascript        |
| CSSフレームワーク    | Pico.css, Flexbox Grid       |

### バックエンド
| 項目                | 内容                         |
|---------------------|------------------------------|
| 使用言語            | PHP                          |
| データベース        | MySQL                        |
| 画像編集            | ImageMagick                  |
| 日付操作            | Carbon                      |
| ダミーデータ        | Faker                       |
| パッケージ管理      | Composer           　        |
| オートローダー      | Composer           　        |
| Webサーバー         | NGINX                        |
| サーバー            | Amazon EC2                   |
| SSL/TLS証明書更新    | Certbot                      |


## 期間
2023年の12月16日から10日間かけて開発しました。

## ER図
当プロジェクトでは、マイグレーションテーブルを除いた場合、postsテーブルのみを使用しています。  
Postエンティティは自己参照を採用しており、reply_to_idがidを参照しています。  
reply_to_idがnullの場合はスレッドとして識別され、一方でreply_to_idに値がある場合はコメントとして識別され、その値はスレッドのidを参照しています。 

![plantUML (4)](https://github.com/AkinoJoey/ImageboardWebapp/assets/124570638/7a330a16-d96c-4263-9f82-578b45199383)


## こだわった点
### データベースオブジェクトの導入
当プロジェクトではデータアクセス層の抽象化のためにDAOを導入しました。  
postDAOインターフェースを作成し、その実装としてpostDAOImplクラスを定義しました。  
postDAOインターフェースでは一般的なCRUD操作を行うメソッドに加えて、トップページのスレッド表示に必要な関数、そしてすべてのコメント表示に必要な関数も定義しました。  
この抽象化により、MySQL以外のデータベースライブラリの実装にも交換できるような状態になりました。  

さらに、コードの再利用性を高めるために、DatabaseManagerクラスを作成しました。  
DatabaseManagerクラスはHTTPリクエストごとの単一の接続の保持、接続の開閉、およびデータベース接続の関連に関する作業を担当しています。  
postDAOImplクラスはこのDatabaseManagerクラスを利用してMySQLインスタンスを取得します。  
これによりpostDAOImplクラスからデータベース接続を効果的に分離させることに成功しました。  

### 視認性向上とスケーラビリティ確保のための画像管理手法

視認性を向上させるためにすべての画像はサムネイル表示するようにしました。  
スレッドやコメントで画像が投稿された場合、すべての画像は512x512ピクセル以下のサムネイル画像が生成されます。  
これらのサムネイルはプレビューとして使用され、プレビューをクリックするとフルバージョンの画像が閲覧可能です。GIFの場合は、最初のフレームだけがサムネイルとして表示されます。画像のリサイズにはImagemagickを採用しました。

さらに、スケーラビリティの確保のために[Pix Pocketと同様](https://github.com/AkinoJoey/OnlineImageHostingService#%E3%83%8F%E3%83%83%E3%82%B7%E3%83%A5%E3%83%99%E3%83%BC%E3%82%B9%E3%81%AE%E3%83%95%E3%82%A1%E3%82%A4%E3%83%AB%E7%AE%A1%E7%90%86%E6%89%8B%E6%B3%95)に、ハッシュベースのファイル管理を採用しています。  
具体的にはアップロードされた画像に対してランダムなハッシュを生成し、そのハッシュから得られる最初の2文字を使用してディレクトリを作成しています。  
このハッシュベースのディレクトリ構造により、ファイルの均等な分布を実現しています。

### ダミーデータ導入システムの構築
テストと開発の効率向上のために、ダミーデータをテーブルに導入するシステムを構築しました。  
まず、SeederインターフェースとAbstractSeederクラスを新たに作成しました。  
Seederインターフェースではデータベースにデータを挿入するためのseed関数と、行のデータ配列を返すcreateRow関数を定義しました。  
AbstractSeederは抽象クラスとして、seed関数と各行にテーブルを挿入するinsertRow関数を実装しながら、具象クラスが実装に必要な変数やメソッドを定義しました。  

次に、AbstractSeederクラスを継承したPostSeederクラスを作成しました。  
PostSeederクラスではcreateRowData関数を実装し、その中でFakerライブラリを使用してダミーデータを効率的に作成できるようにしました。  
さらに、Seederインターフェースを実装するクラスを取得して、実行するSeedクラスを構築しました。  
これにより、```php console seed```という1つのコマンドでダミーデータを簡単に生成でき、テストの準備が容易に行えました。  

## これからの改善点、拡張案
### 投稿後の編集・削除機能
現在、ユーザーデータは投稿に添付していないため、投稿後の編集や削除ができません。  
この課題に対処するために、IPアドレスやセッションなどの情報を活用し、投稿後一定時間内であれば編集や削除が可能な仕組みを構築することで、利便性を向上させたいと考えています。

### スレッド検索機能
検索窓を設置し、単語や文章を入力するとそれに適したスレッドを検索できる機能を追加したいと考えています。
