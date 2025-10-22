<?php
//これはconnect.phpでデータベースをPHPで使えるように接続する処理を関数にしたものです。
//こんな長い記述いちいちデータベースに係る全部のphpに書くのって大変ですよね。
//だったら先に用意だけしておいて、必要なphpファイルにインクルードしてやれば関数１つで
//接続までいけるわけです。
function getDb() : PDO {
  $dsn = 'mysql:dbname=zappy; host=127.0.0.1; charset=utf8';
  $usr = 'root';
  $passwd = '';

  $db = new PDO($dsn, $usr, $passwd);
  //こっちは接続オプションです。接続した後に設定しておけるものです。
  //設定するにはPDOオブジェクトを作成する際の第四引数以降に記述するか、
  //setAttributeメソッドを実行して、引数に決まった定数と値を送ります。
  //正直ここまで設定することはないと思います。

  //PDOの設定に「エラーを出力する」ようにオプションで設定
  //※実はPHP7まではデフォルトがこのERRMODE_SILENTなので、
  //エラーがちゃんと出るようにPDO::ERRMODE_EXCEPTIONを設定する必要がありました。
  //じゃあ俺たち関係なくね？と思いますよね。でも入った会社で使っているのが古いPHPだったら…
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  //こっちは後に必要になるのでいれてあります。
  //一応意味はデータベースから取り出す値を全て文字列型する。
  $db->setAttribute(PDO::ATTR_STRINGIFY_FETCHES,true);

  //オプションで設定できる「PDO::ATTR_PERSISTENT」※P435 だけは他と違い、
  //setAttributeメソッドでは設定できません。
  //PDOクラスをインスタンス化するときに、設定してあげましょう。
  //この「PDO::ATTR_PERSISTENT」は、持続的接続と言い、本来DBが読み込まれた後
  //処理が終わった段階で本来勝手に接続は切れますが、これをtrueにしておくと接続を維持するようになります。
  //何度もDBに接続を繰り返すプログラムだと切断→再接続を繰り返すため処理が重くなってしまいますので
  //その処理を軽減するために設定するオプションになっています。
  //（この後もDBとやりとりするから繋げたまんまにしといてね、って意味です）
  // $db = new PDO($dsn, $usr, $passwd, [PDO::ATTR_PERSISTENT => true]);
  return $db;
}
