# �����M����(for CX-01)

CX-01��syslog�@�\�𗘗p���A�����M�������Ǘ�����ׂ�Web�A�v���P�[�V�����ł��B

����Web�A�v���P�[�V�����͗��p�҂̐ӔC�ɂ����Ă����p���������܂��悤���肢�v���܂��B 

# �g�p���@

SQLite���g���ꍇ�A.env��DB_CONNECTION��sqlite�ɂ��A���̂ق���DB�֌W�̃p�����^���R�����g�A�E�g���܂��B

1. composer install
1. cp .env.example .env
1. php artisan key:generate
1. touch database\database.sqlite
1. php artisan migrate
1. php artisan db:seed

* �������[�U�Fadmin@example.com
* �����p�X���[�h�Fadmin

## License

�x�[�X�ƂȂ��Ă���t���[�����[�N�� Laravel �̂��߁A����Web�A�v���P�[�V������MIT���C�Z���X�Ƃ��܂��B

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
