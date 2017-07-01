<?php

namespace Zilf\Curl;

/**
 * Class Client
 *
 * @method $this set_xoauth2_bearer()
 * @method $this get_xoauth2_bearer()
 * @method $this set_writeheader()
 * @method $this get_writeheader()
 * @method $this set_writefunction()
 * @method $this get_writefunction()
 * @method $this set_verbose()
 * @method $this get_verbose()
 * @method $this set_use_ssl()
 * @method $this get_use_ssl()
 * @method $this set_userpwd()
 * @method $this get_userpwd()
 * @method $this set_username()
 * @method $this get_username()
 * @method $this set_useragent()
 * @method $this get_useragent()
 * @method $this set_upload()
 * @method $this get_upload()
 * @method $this set_unrestricted_auth()
 * @method $this get_unrestricted_auth()
 * @method $this set_unix_socket_path()
 * @method $this get_unix_socket_path()
 * @method $this set_transfer_encoding()
 * @method $this get_transfer_encoding()
 * @method $this set_transfertext()
 * @method $this get_transfertext()
 * @method $this set_timevalue()
 * @method $this get_timevalue()
 * @method $this set_timeout_ms()
 * @method $this get_timeout_ms()
 * @method $this set_timeout()
 * @method $this get_timeout()
 * @method $this set_timecondition()
 * @method $this get_timecondition()
 * @method $this set_tftp_blksize()
 * @method $this get_tftp_blksize()
 * @method $this set_tcp_nodelay()
 * @method $this get_tcp_nodelay()
 * @method $this set_stderr()
 * @method $this get_stderr()
 * @method $this set_ssl_verifystatus()
 * @method $this get_ssl_verifystatus()
 * @method $this set_ssl_verifypeer()
 * @method $this get_ssl_verifypeer()
 * @method $this set_ssl_verifyhost()
 * @method $this get_ssl_verifyhost()
 * @method $this set_ssl_sessionid_cache()
 * @method $this get_ssl_sessionid_cache()
 * @method $this set_ssl_falsestart()
 * @method $this get_ssl_falsestart()
 * @method $this set_ssl_enable_npn()
 * @method $this get_ssl_enable_npn()
 * @method $this set_ssl_enable_alpn()
 * @method $this get_ssl_enable_alpn()
 * @method $this set_ssl_cipher_list()
 * @method $this get_ssl_cipher_list()
 * @method $this set_sslversion()
 * @method $this get_sslversion()
 * @method $this set_sslkeytype()
 * @method $this get_sslkeytype()
 * @method $this set_sslkeypasswd()
 * @method $this get_sslkeypasswd()
 * @method $this set_sslkey()
 * @method $this get_sslkey()
 * @method $this set_sslengine_default()
 * @method $this get_sslengine_default()
 * @method $this set_sslengine()
 * @method $this get_sslengine()
 * @method $this set_sslcerttype()
 * @method $this get_sslcerttype()
 * @method $this set_sslcertpasswd()
 * @method $this get_sslcertpasswd()
 * @method $this set_sslcert()
 * @method $this get_sslcert()
 * @method $this set_ssh_public_keyfile()
 * @method $this get_ssh_public_keyfile()
 * @method $this set_ssh_private_keyfile()
 * @method $this get_ssh_private_keyfile()
 * @method $this set_ssh_knownhosts()
 * @method $this get_ssh_knownhosts()
 * @method $this set_ssh_host_public_key_md5()
 * @method $this get_ssh_host_public_key_md5()
 * @method $this set_ssh_auth_types()
 * @method $this get_ssh_auth_types()
 * @method $this set_socks5_gssapi_service()
 * @method $this get_socks5_gssapi_service()
 * @method $this set_socks5_gssapi_nec()
 * @method $this get_socks5_gssapi_nec()
 * @method $this set_share()
 * @method $this get_share()
 * @method $this set_service_name()
 * @method $this get_service_name()
 * @method $this set_sasl_ir()
 * @method $this get_sasl_ir()
 * @method $this set_safe_upload()
 * @method $this get_safe_upload()
 * @method $this set_rtsp_transport()
 * @method $this get_rtsp_transport()
 * @method $this set_rtsp_stream_uri()
 * @method $this get_rtsp_stream_uri()
 * @method $this set_rtsp_session_id()
 * @method $this get_rtsp_session_id()
 * @method $this set_rtsp_server_cseq()
 * @method $this get_rtsp_server_cseq()
 * @method $this set_rtsp_request()
 * @method $this get_rtsp_request()
 * @method $this set_rtsp_client_cseq()
 * @method $this get_rtsp_client_cseq()
 * @method $this set_returntransfer()
 * @method $this get_returntransfer()
 * @method $this set_resume_from()
 * @method $this get_resume_from()
 * @method $this set_resolve()
 * @method $this get_resolve()
 * @method $this set_referer()
 * @method $this get_referer()
 * @method $this set_redir_protocols()
 * @method $this get_redir_protocols()
 * @method $this set_readfunction()
 * @method $this get_readfunction()
 * @method $this set_readdata()
 * @method $this get_readdata()
 * @method $this set_range()
 * @method $this get_range()
 * @method $this set_random_file()
 * @method $this get_random_file()
 * @method $this set_quote()
 * @method $this get_quote()
 * @method $this set_put()
 * @method $this get_put()
 * @method $this set_proxy_transfer_mode()
 * @method $this get_proxy_transfer_mode()
 * @method $this set_proxy_service_name()
 * @method $this get_proxy_service_name()
 * @method $this set_proxyuserpwd()
 * @method $this get_proxyuserpwd()
 * @method $this set_proxyusername()
 * @method $this get_proxyusername()
 * @method $this set_proxytype()
 * @method $this get_proxytype()
 * @method $this set_proxyport()
 * @method $this get_proxyport()
 * @method $this set_proxypassword()
 * @method $this get_proxypassword()
 * @method $this set_proxyheader()
 * @method $this get_proxyheader()
 * @method $this set_proxyauth()
 * @method $this get_proxyauth()
 * @method $this set_protocols()
 * @method $this get_protocols()
 * @method $this set_progressfunction()
 * @method $this get_progressfunction()
 * @method $this set_private()
 * @method $this get_private()
 * @method $this set_prequote()
 * @method $this get_prequote()
 * @method $this set_postredir()
 * @method $this get_postredir()
 * @method $this set_postquote()
 * @method $this get_postquote()
 * @method $this set_postfields()
 * @method $this get_postfields()
 * @method $this set_post()
 * @method $this get_post()
 * @method $this set_port()
 * @method $this get_port()
 * @method $this set_pipewait()
 * @method $this get_pipewait()
 * @method $this set_pinnedpublickey()
 * @method $this get_pinnedpublickey()
 * @method $this set_path_as_is()
 * @method $this get_path_as_is()
 * @method $this set_password()
 * @method $this get_password()
 * @method $this set_passwdfunction()
 * @method $this get_passwdfunction()
 * @method $this set_nosignal()
 * @method $this get_nosignal()
 * @method $this set_noproxy()
 * @method $this get_noproxy()
 * @method $this set_noprogress()
 * @method $this get_noprogress()
 * @method $this set_nobody()
 * @method $this get_nobody()
 * @method $this set_new_file_perms()
 * @method $this get_new_file_perms()
 * @method $this set_new_directory_perms()
 * @method $this get_new_directory_perms()
 * @method $this set_netrc_file()
 * @method $this get_netrc_file()
 * @method $this set_netrc()
 * @method $this get_netrc()
 * @method $this set_mute()
 * @method $this get_mute()
 * @method $this set_max_send_speed_large()
 * @method $this get_max_send_speed_large()
 * @method $this set_max_recv_speed_large()
 * @method $this get_max_recv_speed_large()
 * @method $this set_maxredirs()
 * @method $this get_maxredirs()
 * @method $this set_maxfilesize()
 * @method $this get_maxfilesize()
 * @method $this set_maxconnects()
 * @method $this get_maxconnects()
 * @method $this set_mail_rcpt()
 * @method $this get_mail_rcpt()
 * @method $this set_mail_from()
 * @method $this get_mail_from()
 * @method $this set_low_speed_time()
 * @method $this get_low_speed_time()
 * @method $this set_low_speed_limit()
 * @method $this get_low_speed_limit()
 * @method $this set_login_options()
 * @method $this get_login_options()
 * @method $this set_localportrange()
 * @method $this get_localportrange()
 * @method $this set_localport()
 * @method $this get_localport()
 * @method $this set_krblevel()
 * @method $this get_krblevel()
 * @method $this set_krb4level()
 * @method $this get_krb4level()
 * @method $this set_keypasswd()
 * @method $this get_keypasswd()
 * @method $this set_issuercert()
 * @method $this get_issuercert()
 * @method $this set_ipresolve()
 * @method $this get_ipresolve()
 * @method $this set_interface()
 * @method $this get_interface()
 * @method $this set_infilesize()
 * @method $this get_infilesize()
 * @method $this set_infile()
 * @method $this get_infile()
 * @method $this set_ignore_content_length()
 * @method $this get_ignore_content_length()
 * @method $this set_http_version()
 * @method $this get_http_version()
 * @method $this set_http_transfer_decoding()
 * @method $this get_http_transfer_decoding()
 * @method $this set_http_content_decoding()
 * @method $this get_http_content_decoding()
 * @method $this set_httpproxytunnel()
 * @method $this get_httpproxytunnel()
 * @method $this set_header()
 * @method $this get_httpheader()
 * @method $this set_httpget()
 * @method $this get_httpget()
 * @method $this set_httpauth()
 * @method $this get_httpauth()
 * @method $this set_http200aliases()
 * @method $this get_http200aliases()
 * @method $this set_headeropt()
 * @method $this get_headeropt()
 * @method $this set_headerfunction()
 * @method $this get_headerfunction()
 * @method $this get_header()
 * @method $this set_ftp_use_pret()
 * @method $this get_ftp_use_pret()
 * @method $this set_ftp_use_epsv()
 * @method $this get_ftp_use_epsv()
 * @method $this set_ftp_use_eprt()
 * @method $this get_ftp_use_eprt()
 * @method $this set_ftp_ssl_ccc()
 * @method $this get_ftp_ssl_ccc()
 * @method $this set_ftp_ssl()
 * @method $this get_ftp_ssl()
 * @method $this set_ftp_skip_pasv_ip()
 * @method $this get_ftp_skip_pasv_ip()
 * @method $this set_ftp_response_timeout()
 * @method $this get_ftp_response_timeout()
 * @method $this set_ftp_filemethod()
 * @method $this get_ftp_filemethod()
 * @method $this set_ftp_create_missing_dirs()
 * @method $this get_ftp_create_missing_dirs()
 * @method $this set_ftp_alternative_to_user()
 * @method $this get_ftp_alternative_to_user()
 * @method $this set_ftp_account()
 * @method $this get_ftp_account()
 * @method $this set_ftpsslauth()
 * @method $this get_ftpsslauth()
 * @method $this set_ftpport()
 * @method $this get_ftpport()
 * @method $this set_ftplistonly()
 * @method $this get_ftplistonly()
 * @method $this set_ftpascii()
 * @method $this get_ftpascii()
 * @method $this set_ftpappend()
 * @method $this get_ftpappend()
 * @method $this set_fresh_connect()
 * @method $this get_fresh_connect()
 * @method $this set_forbid_reuse()
 * @method $this get_forbid_reuse()
 * @method $this set_followlocation()
 * @method $this get_followlocation()
 * @method $this set_filetime()
 * @method $this get_filetime()
 * @method $this set_file()
 * @method $this get_file()
 * @method $this set_failonerror()
 * @method $this get_failonerror()
 * @method $this set_expect_100_timeout_ms()
 * @method $this get_expect_100_timeout_ms()
 * @method $this set_encoding()
 * @method $this get_encoding()
 * @method $this set_egdsocket()
 * @method $this get_egdsocket()
 * @method $this set_dns_use_global_cache()
 * @method $this get_dns_use_global_cache()
 * @method $this set_dns_servers()
 * @method $this get_dns_servers()
 * @method $this set_dns_local_ip6()
 * @method $this get_dns_local_ip6()
 * @method $this set_dns_local_ip4()
 * @method $this get_dns_local_ip4()
 * @method $this set_dns_interface()
 * @method $this get_dns_interface()
 * @method $this set_dns_cache_timeout()
 * @method $this get_dns_cache_timeout()
 * @method $this set_dirlistonly()
 * @method $this get_dirlistonly()
 * @method $this set_customrequest()
 * @method $this get_customrequest()
 * @method $this set_crlfile()
 * @method $this get_crlfile()
 * @method $this set_crlf()
 * @method $this get_crlf()
 * @method $this set_cookiesession()
 * @method $this get_cookiesession()
 * @method $this set_cookielist()
 * @method $this get_cookielist()
 * @method $this set_cookiejar()
 * @method $this get_cookiejar()
 * @method $this set_cookiefile()
 * @method $this get_cookiefile()
 * @method $this set_cookie()
 * @method $this get_cookie()
 * @method $this set_connect_only()
 * @method $this get_connect_only()
 * @method $this set_connecttimeout_ms()
 * @method $this get_connecttimeout_ms()
 * @method $this set_connecttimeout()
 * @method $this get_connecttimeout()
 * @method $this set_closepolicy()
 * @method $this get_closepolicy()
 * @method $this set_certinfo()
 * @method $this get_certinfo()
 * @method $this set_capath()
 * @method $this get_capath()
 * @method $this set_cainfo()
 * @method $this get_cainfo()
 * @method $this set_buffersize()
 * @method $this get_buffersize()
 * @method $this set_binarytransfer()
 * @method $this get_binarytransfer()
 * @method $this set_autoreferer()
 * @method $this get_autoreferer()
 * @method $this set_append()
 * @method $this get_append()
 * @method $this set_address_scope()
 * @method $this get_address_scope()
 * @method $this set_accept_encoding()
 * @method $this get_accept_encoding()
 *
 * @package Zilf\Curl
 */

class Client
{
    private $config = [];

    private $curlOptions = [
        'CURLINFO_HEADER_OUT' => 2,
        'CURLOPT_XOAUTH2_BEARER' => 10220,
        'CURLOPT_WRITEHEADER' => 10029,
        'CURLOPT_WRITEFUNCTION' => 20011,
        'CURLOPT_VERBOSE' => 41,
        'CURLOPT_USE_SSL' => 119,
        'CURLOPT_USERPWD' => 10005,
        'CURLOPT_USERNAME' => 10173,
        'CURLOPT_USERAGENT' => 10018,
        'CURLOPT_URL' => 10002,
        'CURLOPT_UPLOAD' => 46,
        'CURLOPT_UNRESTRICTED_AUTH' => 105,
        'CURLOPT_UNIX_SOCKET_PATH' => 10231,
        'CURLOPT_TRANSFER_ENCODING' => 207,
        'CURLOPT_TRANSFERTEXT' => 53,
        'CURLOPT_TIMEVALUE' => 34,
        'CURLOPT_TIMEOUT_MS' => 155,
        'CURLOPT_TIMEOUT' => 13,
        'CURLOPT_TIMECONDITION' => 33,
        'CURLOPT_TFTP_BLKSIZE' => 178,
        'CURLOPT_TCP_NODELAY' => 121,
        'CURLOPT_STDERR' => 10037,
        'CURLOPT_SSL_VERIFYSTATUS' => 232,
        'CURLOPT_SSL_VERIFYPEER' => 64,
        'CURLOPT_SSL_VERIFYHOST' => 81,
        'CURLOPT_SSL_SESSIONID_CACHE' => 150,
        'CURLOPT_SSL_FALSESTART' => 233,
        'CURLOPT_SSL_ENABLE_NPN' => 225,
        'CURLOPT_SSL_ENABLE_ALPN' => 226,
        'CURLOPT_SSL_CIPHER_LIST' => 10083,
        'CURLOPT_SSLVERSION' => 32,
        'CURLOPT_SSLKEYTYPE' => 10088,
        'CURLOPT_SSLKEYPASSWD' => 10026,
        'CURLOPT_SSLKEY' => 10087,
        'CURLOPT_SSLENGINE_DEFAULT' => 90,
        'CURLOPT_SSLENGINE' => 10089,
        'CURLOPT_SSLCERTTYPE' => 10086,
        'CURLOPT_SSLCERTPASSWD' => 10026,
        'CURLOPT_SSLCERT' => 10025,
        'CURLOPT_SSH_PUBLIC_KEYFILE' => 10152,
        'CURLOPT_SSH_PRIVATE_KEYFILE' => 10153,
        'CURLOPT_SSH_KNOWNHOSTS' => 10183,
        'CURLOPT_SSH_HOST_PUBLIC_KEY_MD5' => 10162,
        'CURLOPT_SSH_AUTH_TYPES' => 151,
        'CURLOPT_SOCKS5_GSSAPI_SERVICE' => 10179,
        'CURLOPT_SOCKS5_GSSAPI_NEC' => 180,
        'CURLOPT_SHARE' => 10100,
        'CURLOPT_SERVICE_NAME' => 10236,
        'CURLOPT_SASL_IR' => 218,
        'CURLOPT_SAFE_UPLOAD' => -1,
        'CURLOPT_RTSP_TRANSPORT' => 10192,
        'CURLOPT_RTSP_STREAM_URI' => 10191,
        'CURLOPT_RTSP_SESSION_ID' => 10190,
        'CURLOPT_RTSP_SERVER_CSEQ' => 194,
        'CURLOPT_RTSP_REQUEST' => 189,
        'CURLOPT_RTSP_CLIENT_CSEQ' => 193,
        'CURLOPT_RETURNTRANSFER' => 19913,
        'CURLOPT_RESUME_FROM' => 21,
        'CURLOPT_RESOLVE' => 10203,
        'CURLOPT_REFERER' => 10016,
        'CURLOPT_REDIR_PROTOCOLS' => -1,
        'CURLOPT_READFUNCTION' => 20012,
        'CURLOPT_READDATA' => 10009,
        'CURLOPT_RANGE' => 10007,
        'CURLOPT_RANDOM_FILE' => 10076,
        'CURLOPT_QUOTE' => 10028,
        'CURLOPT_PUT' => 54,
        'CURLOPT_PROXY_TRANSFER_MODE' => 166,
        'CURLOPT_PROXY_SERVICE_NAME' => 10235,
        'CURLOPT_PROXYUSERPWD' => 10006,
        'CURLOPT_PROXYUSERNAME' => 10175,
        'CURLOPT_PROXYTYPE' => 101,
        'CURLOPT_PROXYPORT' => 59,
        'CURLOPT_PROXYPASSWORD' => 10176,
        'CURLOPT_PROXYHEADER' => 10228,
        'CURLOPT_PROXYAUTH' => 111,
        'CURLOPT_PROXY' => 10004,
        'CURLOPT_PROTOCOLS' => -1,
        'CURLOPT_PROGRESSFUNCTION' => 20056,
        'CURLOPT_PRIVATE' => 10103,
        'CURLOPT_PREQUOTE' => 10093,
        'CURLOPT_POSTREDIR' => 161,
        'CURLOPT_POSTQUOTE' => 10039,
        'CURLOPT_POSTFIELDS' => 10015,
        'CURLOPT_POST' => 47,
        'CURLOPT_PORT' => 3,
        'CURLOPT_PIPEWAIT' => 237,
        'CURLOPT_PINNEDPUBLICKEY' => 10230,
        'CURLOPT_PATH_AS_IS' => 234,
        'CURLOPT_PASSWORD' => 10174,
        'CURLOPT_PASSWDFUNCTION' => -1,
        'CURLOPT_NOSIGNAL' => 99,
        'CURLOPT_NOPROXY' => 10177,
        'CURLOPT_NOPROGRESS' => 43,
        'CURLOPT_NOBODY' => 44,
        'CURLOPT_NEW_FILE_PERMS' => 159,
        'CURLOPT_NEW_DIRECTORY_PERMS' => 160,
        'CURLOPT_NETRC_FILE' => 10118,
        'CURLOPT_NETRC' => 51,
        'CURLOPT_MUTE' => -1,
        'CURLOPT_MAX_SEND_SPEED_LARGE' => -1,
        'CURLOPT_MAX_RECV_SPEED_LARGE' => -1,
        'CURLOPT_MAXREDIRS' => 68,
        'CURLOPT_MAXFILESIZE' => 114,
        'CURLOPT_MAXCONNECTS' => 71,
        'CURLOPT_MAIL_RCPT' => 10187,
        'CURLOPT_MAIL_FROM' => 10186,
        'CURLOPT_LOW_SPEED_TIME' => 20,
        'CURLOPT_LOW_SPEED_LIMIT' => 19,
        'CURLOPT_LOGIN_OPTIONS' => 10224,
        'CURLOPT_LOCALPORTRANGE' => 140,
        'CURLOPT_LOCALPORT' => 139,
        'CURLOPT_KRBLEVEL' => 10063,
        'CURLOPT_KRB4LEVEL' => 10063,
        'CURLOPT_KEYPASSWD' => 10026,
        'CURLOPT_ISSUERCERT' => 10170,
        'CURLOPT_IPRESOLVE' => 113,
        'CURLOPT_INTERFACE' => 10062,
        'CURLOPT_INFILESIZE' => 14,
        'CURLOPT_INFILE' => 10009,
        'CURLOPT_IGNORE_CONTENT_LENGTH' => 136,
        'CURLOPT_HTTP_VERSION' => 84,
        'CURLOPT_HTTP_TRANSFER_DECODING' => 157,
        'CURLOPT_HTTP_CONTENT_DECODING' => 158,
        'CURLOPT_HTTPPROXYTUNNEL' => 61,
        'CURLOPT_HTTPHEADER' => 10023,
        'CURLOPT_HTTPGET' => 80,
        'CURLOPT_HTTPAUTH' => 107,
        'CURLOPT_HTTP200ALIASES' => 10104,
        'CURLOPT_HEADEROPT' => 229,
        'CURLOPT_HEADERFUNCTION' => 20079,
        'CURLOPT_HEADER' => 42,
        'CURLOPT_FTP_USE_PRET' => 188,
        'CURLOPT_FTP_USE_EPSV' => 85,
        'CURLOPT_FTP_USE_EPRT' => 106,
        'CURLOPT_FTP_SSL_CCC' => 154,
        'CURLOPT_FTP_SSL' => 119,
        'CURLOPT_FTP_SKIP_PASV_IP' => 137,
        'CURLOPT_FTP_RESPONSE_TIMEOUT' => 112,
        'CURLOPT_FTP_FILEMETHOD' => 138,
        'CURLOPT_FTP_CREATE_MISSING_DIRS' => 110,
        'CURLOPT_FTP_ALTERNATIVE_TO_USER' => 10147,
        'CURLOPT_FTP_ACCOUNT' => 10134,
        'CURLOPT_FTPSSLAUTH' => 129,
        'CURLOPT_FTPPORT' => 10017,
        'CURLOPT_FTPLISTONLY' => 48,
        'CURLOPT_FTPASCII' => -1,
        'CURLOPT_FTPAPPEND' => 50,
        'CURLOPT_FRESH_CONNECT' => 74,
        'CURLOPT_FORBID_REUSE' => 75,
        'CURLOPT_FOLLOWLOCATION' => 52,
        'CURLOPT_FILETIME' => 69,
        'CURLOPT_FILE' => 10001,
        'CURLOPT_FAILONERROR' => 45,
        'CURLOPT_EXPECT_100_TIMEOUT_MS' => 227,
        'CURLOPT_ENCODING' => 10102,
        'CURLOPT_EGDSOCKET' => 10077,
        'CURLOPT_DNS_USE_GLOBAL_CACHE' => 91,
        'CURLOPT_DNS_SERVERS' => 10211,
        'CURLOPT_DNS_LOCAL_IP6' => 10223,
        'CURLOPT_DNS_LOCAL_IP4' => 10222,
        'CURLOPT_DNS_INTERFACE' => 10221,
        'CURLOPT_DNS_CACHE_TIMEOUT' => 92,
        'CURLOPT_DIRLISTONLY' => 48,
        'CURLOPT_CUSTOMREQUEST' => 10036,
        'CURLOPT_CRLFILE' => 10169,
        'CURLOPT_CRLF' => 27,
        'CURLOPT_COOKIESESSION' => 96,
        'CURLOPT_COOKIELIST' => 10135,
        'CURLOPT_COOKIEJAR' => 10082,
        'CURLOPT_COOKIEFILE' => 10031,
        'CURLOPT_COOKIE' => 10022,
        'CURLOPT_CONNECT_ONLY' => 141,
        'CURLOPT_CONNECTTIMEOUT_MS' => 156,
        'CURLOPT_CONNECTTIMEOUT' => 78,
        'CURLOPT_CLOSEPOLICY' => 72,
        'CURLOPT_CERTINFO' => -1,
        'CURLOPT_CAPATH' => 10097,
        'CURLOPT_CAINFO' => 10065,
        'CURLOPT_BUFFERSIZE' => 98,
        'CURLOPT_BINARYTRANSFER' => 19914,
        'CURLOPT_AUTOREFERER' => 58,
        'CURLOPT_APPEND' => 50,
        'CURLOPT_ADDRESS_SCOPE' => 171,
        'CURLOPT_ACCEPT_ENCODING' => 10102,
    ];

    private $method;
    private $baseUrl;
    private $parameters;

    private $timeout = 15;
    private $connecttimeout = 15;

    /**
     * Client constructor.
     *      *    $client = new Client([
     *         'base_uri'        => 'http://www.test.com/',
     *         'timeout'         => 0,
     *         'connecttimeout'         => 0,
     *         'proxy'           => '192.168.16.1:10'
     *     ]);
     *
     *    $client = new Client([
     *         'base_uri'        => 'http://www.test.com/',
     *         'timeout'         => 0,
     *         'proxy'           => [
     *                                '192.168.16.1:10',
     *                                'username:password'
     *                              ]
     *     ]);
     *
     * @param array $config
     * @throws \ErrorException
     */
    public function __construct(array $config = [])
    {
        if (!extension_loaded('curl')) {
            throw new \ErrorException('curl library is not loaded');
        }

        $this->config['CURLOPT_IMEOUT'] = $this->timeout;
        $this->config['CURLOPT_CONNECTTIMEOUT'] = $this->connecttimeout;

        if ($config) {
            foreach ($config as $key => $value) {
                switch (strtolower($key)) {
                    case 'baseurl':
                        $this->baseUrl = rtrim($value, '/') . '/';
                        unset($config[$key]);
                        break;

                    case 'method':
                        $this->method = $value;
                        unset($config[$key]);
                        break;

                    case 'timeout':
                        $this->config['CURLOPT_IMEOUT'] = intval($value);  //在尝试连接时等待的秒数。设置为0，则无限等待。
                        unset($config[$key]);
                        break;

                    case 'connecttimeout':
                        $this->config['CURLOPT_CONNECTTIMEOUT'] = intval($value);  //在尝试连接时等待的秒数。设置为0，则无限等待。
                        unset($config[$key]);
                        break;

                    case 'proxy':
                        if (is_array($value) && !empty($value)) {
                            $this->config['CURLOPT_PROXY'] = $value[0];
                            if (isset($value[1])) $this->config['CURLOPT_PROXYUSERPWD'] = $value[1];
                        } else {
                            $this->config['CURLOPT_PROXY'] = $value;
                        }
                        unset($config[$key]);
                        break;
                }
            }
        }

        $this->config = $config;
    }

    /**
     * @param $url
     * @param array $parameters
     * @return CurlResponse
     */
    public function get($url, $parameters = [])
    {
        $this->request('GET', $url, $parameters);

        return $this->exec();
    }

    /**
     * @param $url
     * @param mixed $parameters
     * @return CurlResponse
     */
    public function post($url, $parameters = '')
    {
        $this->request('POST', $url, $parameters);

        return $this->exec();
    }

    /**
     * @param string $method
     * @param string $url
     * @param mixed $parameters
     * @return CurlResponse
     */
    public function request($method = '', $url = '', $parameters = '')
    {
        //请求方式
        $this->method = $method;
        $this->parameters = $parameters;
        $this->config['CURLOPT_URL'] = $this->baseUrl . $url;

        return $this->exec();
    }

    /**
     * @return CurlResponse
     * @throws CurlException
     */
    public function exec()
    {
        $curlObj = $this->get_curlObj();

        return new CurlResponse($this, $curlObj);
    }

    /**
     * curl_init 对象
     */
    public function get_curlObj(){
        //curl 请求的句柄
        $curlObj = curl_init();

        $this->_set_method();

        if (empty($this->config['CURLOPT_URL'])) {
            throw new CurlException('请设置请求的url');
        }

        //TRUE 将curl_exec()获取的信息以字符串返回，而不是直接输出。
        $this->config['CURLOPT_RETURNTRANSFER'] = true;

        //启用时会将头文件的信息作为数据流输出。
        if (!isset($this->config['CURLOPT_HEADER'])) {
            $this->config['CURLOPT_HEADER'] = true;
        }

        //发送请求的字符串
        if (!isset($this->config['CURLINFO_HEADER_OUT'])) {
            $this->config['CURLINFO_HEADER_OUT'] = true;
        }

        //判断是否是ssl请求
        if (stripos($this->config['CURLOPT_URL'], 'http://') === 0) {
        } elseif (stripos($this->config['CURLOPT_URL'], 'https://') === 0) {
            $this->set_ssl();
        } else {
            throw new CurlException('请求的url必须以http或https开头');
        }

        foreach ($this->config as $key => $row) {
            curl_setopt($curlObj, $this->curlOptions[$key], $row);
        }

        return $curlObj;
    }

    /**
     * @param $url
     * @param array $parameters
     * @return array
     */
    public function getAsync($url,$parameters = []){
        return $this->requestAsync('GET', $url, $parameters);
    }

    /**
     * @param $url
     * @param array $parameters
     * @return array
     */
    public function postAsync($url,$parameters = []){
        return $this->requestAsync('GET', $url, $parameters);
    }

    /**
     * @param string $method
     * @param string $url
     * @param string $parameters
     * @return array
     */
    public function requestAsync($method = '', $url = '', $parameters = ''){
        $curlObj_arr = [];
        $response_arr = [];

        //请求方式
        $this->method = $method;

        $master = curl_multi_init();

        if(is_array($url)){

            foreach ($url as $key => $one_url){
                $this->parameters = $parameters[$key] ?? [];
                $this->config['CURLOPT_URL'] = $this->baseUrl . $one_url;
                $curlObj_arr[] = $curlObj = $this->get_curlObj();
                curl_multi_add_handle($master, $curlObj);
            }

        }else{

            $this->parameters = $parameters;
            $this->config['CURLOPT_URL'] = $this->baseUrl . $url;
            $curlObj_arr[] = $curlObj = $this->get_curlObj();
            curl_multi_add_handle($master, $curlObj);
        }

        $active=null;

        // 执行批处理句柄
        do {
            $mrc = curl_multi_exec($master, $active);
        } while ($mrc == CURLM_CALL_MULTI_PERFORM);

        while ($active && $mrc == CURLM_OK)
        {
            // add this line
            while (curl_multi_exec($master, $active) === CURLM_CALL_MULTI_PERFORM);

            if (curl_multi_select($master) != -1)
            {
                do {
                    $mrc = curl_multi_exec($master, $active);
                    if ($mrc == CURLM_OK)
                    {
                        /*while($info = curl_multi_info_read($master))
                        {
                        }*/
                    }
                } while ($mrc == CURLM_CALL_MULTI_PERFORM);
            }
        }

        foreach ($curlObj_arr as $i => $url) {
            $content = curl_multi_getcontent($curlObj_arr[$i]);
            $response_arr[] = new CurlResponse($this, $curlObj_arr[$i],$content);
            curl_close($curlObj_arr[$i]);
        }

        curl_multi_close($master);

        return $response_arr;
    }


    /**
     * 添加需要上传的文件
     *
     * @param string $postname 文件名称
     * @param string $filename 文件绝对路径
     * @param string $mimetype 文件的mimetype
     * @return $this
     */
    public function add_upload_file(string $postname, string $filename, string $mimetype = '')
    {

        $this->parameters[$postname] = new \CURLFile($filename, $mimetype, $postname);

        return $this;
    }

    /**
     * @param $cookie_name
     * @param string $path cookie的存储路径,为空则为系统默认的缓存路径
     * @return $this
     */
    public function set_open_cookie($cookie_name, $path = '')
    {
        if (empty($path)) {
            $path = sys_get_temp_dir();
        }

        $filename = rtrim($path, '/') . DIRECTORY_SEPARATOR . $cookie_name;

        $this->config['CURLOPT_COOKIEJAR'] = $filename;
        $this->config['CURLOPT_COOKIEFILE'] = $filename;

        unset($filename);

        return $this;
    }

    /**
     * 设置ssl请求
     *
     * @param string $cacert // CA根证书（用来验证的网站证书是否是CA颁布）
     * @param string $sslcert 一个包含 PEM 格式证书的文件名。
     * @param string $sslcertpasswd 使用CURLOPT_SSLCERT证书需要的密码。
     * @param int $ssl_verifyhost 设置为 1 是检查服务器SSL证书中是否存在一个公用名 设置成 2，会检查公用名是否存在，并且是否与提供的主机名匹配。 0 为不检查名称。 在生产环境中，这个值应该是 2（默认值）。
     *
     * @return $this
     */
    public function set_ssl(string $cacert = '', string $sslcert = '', string $sslcertpasswd = '', $ssl_verifyhost = 2)
    {
        if ($sslcert)
            $this->config['CURLOPT_SSLCERT'] = $sslcert;

        if ($sslcertpasswd)
            $this->config['CURLOPT_SSLCERTPASSWD'] = $sslcertpasswd;

        if (!empty($cacert_path)) {

            $this->config['CURLOPT_SSL_VERIFYPEER'] = true; // 只信任CA颁布的证书
            $this->config['CURLOPT_CAINFO'] = $cacert; // CA根证书（用来验证的网站证书是否是CA颁布）

        } else {
            $this->config['CURLOPT_SSL_VERIFYPEER'] = false;
        }

        $this->config['CURLOPT_SSL_VERIFYHOST'] = $ssl_verifyhost;

        return $this;
    }

    /**
     * 设置请求的方法，以及请求参数的设置
     * @throws \Exception
     */
    private function _set_method()
    {
        switch (strtoupper($this->method)) {
            case 'HEAD':
                //CURLOPT_NOBODY TRUE 时将不输出 BODY 部分。同时 Mehtod 变成了 HEAD。修改为 FALSE 时不会变成 GET。
                if (!isset($this->config['CURLOPT_NOBODY'])) {
                    $this->config['CURLOPT_NOBODY'] = true;
                }
                break;

            case 'GET':

                if (!empty($this->config['parameters'])) {

                    $url = (stripos($this->config['CURLOPT_URL'], '?') !== false) ? '&' : '?';

                    if (is_array($this->config['parameters'])) {  //参数是数组
                        $url .= http_build_query($this->_parameters, '', '&');
                    } else { //参数是字符串
                        $url .= $this->config['parameters'];
                    }

                    $this->config['CURLOPT_URL'] = $url;
                    unset($url);
                }

                $this->config['CURLOPT_HTTPGET'] = true;  //TRUE 时会设置 HTTP 的 method 为 GET

                break;

            case 'POST':

                if (!empty($this->parameters) && is_array($this->parameters)) { //参数是数组
                    $data = http_build_query($this->parameters); //为了更好的兼容性
                } else {  //参数是字符串
                    $data = $this->parameters;
                }

                $this->config['CURLOPT_POSTFIELDS'] = $data;  //post请求的数据
                $this->config['CURLOPT_POST'] = true;   //TRUE 时会发送 POST 请求，类型为：application/x-www-form-urlencoded，是 HTML 表单提交时最常见的一种。

                unset($data);

                break;

            default:
                throw new CurlException('该请求方式不支持！');
        }
    }

    /**
     * 获取配置信息
     *
     * @param string $name
     * @return array|mixed
     */
    function getConfig($name = '')
    {
        if ($name) {
            return $this->config[$name];
        } else {
            return $this->config;
        }
    }

    /**
     * 获取所有的curlopt的名称及值;
     *
     * @param string $name
     * @return array|mixed
     */
    public function getCurlOptions(string $name = '')
    {
        if ($name) {
            return $this->curlOptions[$name];
        } else {
            return $this->curlOptions;
        }
    }

    /**
     * 设置文件的头信息
     *
     * @param array $data
     * @return $this
     */
    public function set_httpHeader($data = [])
    {
        //将二维数组转为一维数组
        $result = [];
        foreach ($data as $key => $row) {
            if (is_array($row)) {
                if (isset($row[0])) {
                    $result[] = $row[0];
                }
            } else {
                $result[] = $row;
            }
        }

        $this->config['CURLOPT_HTTPHEADER'] = $data;

        return $this;
    }

    /**
     * 设置代理请求
     *
     * @param $proxy   如: 192.168.2.2:220
     * @param string $userpwd 如: admin:admin
     * @return $this
     */
    public function set_proxy($proxy,$userpwd=''){
        $this->config['CURLOPT_PROXY'] = $proxy;

        if ($userpwd)
            $this->config['CURLOPT_PROXYUSERPWD'] = $userpwd;

        return $this;
    }

    /**
     * @return array
     */
    public function get_proxy(){
        return [
            'CURLOPT_PROXY' => $this->config['CURLOPT_PROXY'],
            'CURLOPT_PROXYUSERPWD' => $this->config['CURLOPT_PROXYUSERPWD'],
        ];
    }

    /**
     * @param $data
     * @return $this
     */
    public function set_parameters($data)
    {
        $this->parameters = $data;
        return $this;
    }

    /**
     * 获取请求的url地址
     * @return string
     */
    public function get_parameters()
    {
        return $this->parameters;
    }

    /**
     * @param $time
     * @return $this
     */
    public function setTimeout($time)
    {
        $this->config['CURLOPT_CONNECTTIMEOUT'] = intval($time);
        return $this;
    }

    /**
     * 获取请求的url地址
     * @return string
     */
    public function getTimeout()
    {
        return $this->config['CURLOPT_CONNECTTIMEOUT'] ?? 0;
    }

    /**
     * @param $url
     * @return $this
     */
    public function set_Url($url)
    {
        return $this->config['CURLOPT_URL'] = $url;
        return $this;
    }

    /**
     * 获取请求的url地址
     * @return string
     */
    public function get_url()
    {
        return $this->config['CURLOPT_URL'];
    }

    /**
     * @param $method
     * @return $this
     */
    public function set_method($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * 获取请求方式
     */
    public function get_method()
    {
        return $this->method;
    }

    /**
     * 方法
     *  $client->setHttpHeader($value);
     *  $client->HttpHeader($value);
     *
     * @param $name
     * @param $arguments
     * @return $this
     */
    function __call($name, $arguments)
    {
        if (preg_match('/^GET/is', $name)) {
            $name = preg_replace('/^GET/is', '', strtoupper($name));
            return $this->config['CURLOPT' . $name];
        }

        $this->setOptions($name, $arguments);
        return $this;
    }

    /**
     * @param $name
     * @param $value
     * @return $this
     */
    function __set($name, $value)
    {
        $this->setOptions($name, $value);
        return $this;
    }

    private function setOptions($name, $arguments)
    {
        $name = strtoupper($name);
        $name = preg_replace('/^SET/is', '', $name);
        $name = 'CURLOPT' . $name;

        if (array_key_exists($name, $this->curlOptions)) {
            $this->config[$name] = $arguments[0] ?? '';
        } else {
            throw new \RuntimeException('curl的参数: ' . $name . '不存在的,请检查设置');
        }
    }

}