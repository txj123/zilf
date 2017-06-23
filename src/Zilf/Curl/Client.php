<?php

namespace Zilf\Curl;

/**
 * Class Client
 *
 * @method $this setCURL_VERSION_SSL()
 * @method $this setCURL_VERSION_LIBZ()
 * @method $this setCURL_VERSION_KERBEROS4()
 * @method $this setCURL_VERSION_IPV6()
 * @method $this setCURL_TIMECOND_LASTMOD()
 * @method $this setCURL_TIMECOND_IFUNMODSINCE()
 * @method $this setCURL_TIMECOND_IFMODSINCE()
 * @method $this setCURL_SSLVERSION_TLSv1_2()
 * @method $this setCURL_SSLVERSION_TLSv1_1()
 * @method $this setCURL_SSLVERSION_TLSv1_0()
 * @method $this setCURL_SSLVERSION_TLSv1()
 * @method $this setCURL_SSLVERSION_SSLv3()
 * @method $this setCURL_SSLVERSION_SSLv2()
 * @method $this setCURL_SSLVERSION_DEFAULT()
 * @method $this setCURL_REDIR_POST_ALL()
 * @method $this setCURL_REDIR_POST_303()
 * @method $this setCURL_REDIR_POST_302()
 * @method $this setCURL_REDIR_POST_301()
 * @method $this setCURL_PUSH_OK()
 * @method $this setCURL_PUSH_DENY()
 * @method $this setCURL_NETRC_REQUIRED()
 * @method $this setCURL_NETRC_OPTIONAL()
 * @method $this setCURL_NETRC_IGNORED()
 * @method $this setCURL_LOCK_DATA_SSL_SESSION()
 * @method $this setCURL_LOCK_DATA_DNS()
 * @method $this setCURL_LOCK_DATA_COOKIE()
 * @method $this setCURL_IPRESOLVE_WHATEVER()
 * @method $this setCURL_IPRESOLVE_V6()
 * @method $this setCURL_IPRESOLVE_V4()
 * @method $this setCURL_HTTP_VERSION_NONE()
 * @method $this setCURL_HTTP_VERSION_2_PRIOR_KNOWLEDGE()
 * @method $this setCURL_HTTP_VERSION_2_0()
 * @method $this setCURL_HTTP_VERSION_2TLS()
 * @method $this setCURL_HTTP_VERSION_2()
 * @method $this setCURL_HTTP_VERSION_1_1()
 * @method $this setCURL_HTTP_VERSION_1_0()
 * @method $this setCURLVERSION_NOW()
 * @method $this setCURLSSH_AUTH_AGENT()
 * @method $this setCURLSHOPT_UNSHARE()
 * @method $this setCURLSHOPT_SHARE()
 * @method $this setCURLPROXY_SOCKS5()
 * @method $this setCURLPROXY_SOCKS4()
 * @method $this setCURLPROXY_HTTP_1_0()
 * @method $this setCURLPROXY_HTTP()
 * @method $this setCURLPROTO_TFTP()
 * @method $this setCURLPROTO_TELNET()
 * @method $this setCURLPROTO_SMBS()
 * @method $this setCURLPROTO_SMB()
 * @method $this setCURLPROTO_SFTP()
 * @method $this setCURLPROTO_SCP()
 * @method $this setCURLPROTO_LDAPS()
 * @method $this setCURLPROTO_LDAP()
 * @method $this setCURLPROTO_HTTPS()
 * @method $this setCURLPROTO_HTTP()
 * @method $this setCURLPROTO_FTPS()
 * @method $this setCURLPROTO_FTP()
 * @method $this setCURLPROTO_FILE()
 * @method $this setCURLPROTO_DICT()
 * @method $this setCURLPROTO_ALL()
 * @method $this setCURLPIPE_NOTHING()
 * @method $this setCURLPIPE_MULTIPLEX()
 * @method $this setCURLPIPE_HTTP1()
 * @method $this setCURLOPT_XOAUTH2_BEARER()
 * @method $this setCURLOPT_WRITEHEADER()
 * @method $this setCURLOPT_WRITEFUNCTION()
 * @method $this setCURLOPT_VERBOSE()
 * @method $this setCURLOPT_USE_SSL()
 * @method $this setCURLOPT_USERPWD()
 * @method $this setCURLOPT_USERNAME()
 * @method $this setCURLOPT_USERAGENT()
 * @method $this setCURLOPT_URL()
 * @method $this setCURLOPT_UPLOAD()
 * @method $this setCURLOPT_UNRESTRICTED_AUTH()
 * @method $this setCURLOPT_UNIX_SOCKET_PATH()
 * @method $this setCURLOPT_TRANSFER_ENCODING()
 * @method $this setCURLOPT_TRANSFERTEXT()
 * @method $this setCURLOPT_TIMEVALUE()
 * @method $this setCURLOPT_TIMEOUT_MS()
 * @method $this setCURLOPT_TIMEOUT()
 * @method $this setCURLOPT_TIMECONDITION()
 * @method $this setCURLOPT_TFTP_BLKSIZE()
 * @method $this setCURLOPT_TCP_NODELAY()
 * @method $this setCURLOPT_STDERR()
 * @method $this setCURLOPT_SSL_VERIFYSTATUS()
 * @method $this setCURLOPT_SSL_VERIFYPEER()
 * @method $this setCURLOPT_SSL_VERIFYHOST()
 * @method $this setCURLOPT_SSL_SESSIONID_CACHE()
 * @method $this setCURLOPT_SSL_FALSESTART()
 * @method $this setCURLOPT_SSL_ENABLE_NPN()
 * @method $this setCURLOPT_SSL_ENABLE_ALPN()
 * @method $this setCURLOPT_SSL_CIPHER_LIST()
 * @method $this setCURLOPT_SSLVERSION()
 * @method $this setCURLOPT_SSLKEYTYPE()
 * @method $this setCURLOPT_SSLKEYPASSWD()
 * @method $this setCURLOPT_SSLKEY()
 * @method $this setCURLOPT_SSLENGINE_DEFAULT()
 * @method $this setCURLOPT_SSLENGINE()
 * @method $this setCURLOPT_SSLCERTTYPE()
 * @method $this setCURLOPT_SSLCERTPASSWD()
 * @method $this setCURLOPT_SSLCERT()
 * @method $this setCURLOPT_SSH_PUBLIC_KEYFILE()
 * @method $this setCURLOPT_SSH_PRIVATE_KEYFILE()
 * @method $this setCURLOPT_SSH_KNOWNHOSTS()
 * @method $this setCURLOPT_SSH_HOST_PUBLIC_KEY_MD5()
 * @method $this setCURLOPT_SSH_AUTH_TYPES()
 * @method $this setCURLOPT_SOCKS5_GSSAPI_SERVICE()
 * @method $this setCURLOPT_SOCKS5_GSSAPI_NEC()
 * @method $this setCURLOPT_SHARE()
 * @method $this setCURLOPT_SERVICE_NAME()
 * @method $this setCURLOPT_SASL_IR()
 * @method $this setCURLOPT_SAFE_UPLOAD()
 * @method $this setCURLOPT_RTSP_TRANSPORT()
 * @method $this setCURLOPT_RTSP_STREAM_URI()
 * @method $this setCURLOPT_RTSP_SESSION_ID()
 * @method $this setCURLOPT_RTSP_SERVER_CSEQ()
 * @method $this setCURLOPT_RTSP_REQUEST()
 * @method $this setCURLOPT_RTSP_CLIENT_CSEQ()
 * @method $this setCURLOPT_RETURNTRANSFER()
 * @method $this setCURLOPT_RESUME_FROM()
 * @method $this setCURLOPT_RESOLVE()
 * @method $this setCURLOPT_REFERER()
 * @method $this setCURLOPT_REDIR_PROTOCOLS()
 * @method $this setCURLOPT_READFUNCTION()
 * @method $this setCURLOPT_READDATA()
 * @method $this setCURLOPT_RANGE()
 * @method $this setCURLOPT_RANDOM_FILE()
 * @method $this setCURLOPT_QUOTE()
 * @method $this setCURLOPT_PUT()
 * @method $this setCURLOPT_PROXY_TRANSFER_MODE()
 * @method $this setCURLOPT_PROXY_SERVICE_NAME()
 * @method $this setCURLOPT_PROXYUSERPWD()
 * @method $this setCURLOPT_PROXYUSERNAME()
 * @method $this setCURLOPT_PROXYTYPE()
 * @method $this setCURLOPT_PROXYPORT()
 * @method $this setCURLOPT_PROXYPASSWORD()
 * @method $this setCURLOPT_PROXYHEADER()
 * @method $this setCURLOPT_PROXYAUTH()
 * @method $this setCURLOPT_PROXY()
 * @method $this setCURLOPT_PROTOCOLS()
 * @method $this setCURLOPT_PROGRESSFUNCTION()
 * @method $this setCURLOPT_PRIVATE()
 * @method $this setCURLOPT_PREQUOTE()
 * @method $this setCURLOPT_POSTREDIR()
 * @method $this setCURLOPT_POSTQUOTE()
 * @method $this setCURLOPT_POSTFIELDS()
 * @method $this setCURLOPT_POST()
 * @method $this setCURLOPT_PORT()
 * @method $this setCURLOPT_PIPEWAIT()
 * @method $this setCURLOPT_PINNEDPUBLICKEY()
 * @method $this setCURLOPT_PATH_AS_IS()
 * @method $this setCURLOPT_PASSWORD()
 * @method $this setCURLOPT_PASSWDFUNCTION()
 * @method $this setCURLOPT_NOSIGNAL()
 * @method $this setCURLOPT_NOPROXY()
 * @method $this setCURLOPT_NOPROGRESS()
 * @method $this setCURLOPT_NOBODY()
 * @method $this setCURLOPT_NEW_FILE_PERMS()
 * @method $this setCURLOPT_NEW_DIRECTORY_PERMS()
 * @method $this setCURLOPT_NETRC_FILE()
 * @method $this setCURLOPT_NETRC()
 * @method $this setCURLOPT_MUTE()
 * @method $this setCURLOPT_MAX_SEND_SPEED_LARGE()
 * @method $this setCURLOPT_MAX_RECV_SPEED_LARGE()
 * @method $this setCURLOPT_MAXREDIRS()
 * @method $this setCURLOPT_MAXFILESIZE()
 * @method $this setCURLOPT_MAXCONNECTS()
 * @method $this setCURLOPT_MAIL_RCPT()
 * @method $this setCURLOPT_MAIL_FROM()
 * @method $this setCURLOPT_LOW_SPEED_TIME()
 * @method $this setCURLOPT_LOW_SPEED_LIMIT()
 * @method $this setCURLOPT_LOGIN_OPTIONS()
 * @method $this setCURLOPT_LOCALPORTRANGE()
 * @method $this setCURLOPT_LOCALPORT()
 * @method $this setCURLOPT_KRBLEVEL()
 * @method $this setCURLOPT_KRB4LEVEL()
 * @method $this setCURLOPT_KEYPASSWD()
 * @method $this setCURLOPT_ISSUERCERT()
 * @method $this setCURLOPT_IPRESOLVE()
 * @method $this setCURLOPT_INTERFACE()
 * @method $this setCURLOPT_INFILESIZE()
 * @method $this setCURLOPT_INFILE()
 * @method $this setCURLOPT_IGNORE_CONTENT_LENGTH()
 * @method $this setCURLOPT_HTTP_VERSION()
 * @method $this setCURLOPT_HTTP_TRANSFER_DECODING()
 * @method $this setCURLOPT_HTTP_CONTENT_DECODING()
 * @method $this setCURLOPT_HTTPPROXYTUNNEL()
 * @method $this setCURLOPT_HTTPHEADER()
 * @method $this setCURLOPT_HTTPGET()
 * @method $this setCURLOPT_HTTPAUTH()
 * @method $this setCURLOPT_HTTP200ALIASES()
 * @method $this setCURLOPT_HEADEROPT()
 * @method $this setCURLOPT_HEADERFUNCTION()
 * @method $this setCURLOPT_HEADER()
 * @method $this setCURLOPT_FTP_USE_PRET()
 * @method $this setCURLOPT_FTP_USE_EPSV()
 * @method $this setCURLOPT_FTP_USE_EPRT()
 * @method $this setCURLOPT_FTP_SSL_CCC()
 * @method $this setCURLOPT_FTP_SSL()
 * @method $this setCURLOPT_FTP_SKIP_PASV_IP()
 * @method $this setCURLOPT_FTP_RESPONSE_TIMEOUT()
 * @method $this setCURLOPT_FTP_FILEMETHOD()
 * @method $this setCURLOPT_FTP_CREATE_MISSING_DIRS()
 * @method $this setCURLOPT_FTP_ALTERNATIVE_TO_USER()
 * @method $this setCURLOPT_FTP_ACCOUNT()
 * @method $this setCURLOPT_FTPSSLAUTH()
 * @method $this setCURLOPT_FTPPORT()
 * @method $this setCURLOPT_FTPLISTONLY()
 * @method $this setCURLOPT_FTPASCII()
 * @method $this setCURLOPT_FTPAPPEND()
 * @method $this setCURLOPT_FRESH_CONNECT()
 * @method $this setCURLOPT_FORBID_REUSE()
 * @method $this setCURLOPT_FOLLOWLOCATION()
 * @method $this setCURLOPT_FILETIME()
 * @method $this setCURLOPT_FILE()
 * @method $this setCURLOPT_FAILONERROR()
 * @method $this setCURLOPT_EXPECT_100_TIMEOUT_MS()
 * @method $this setCURLOPT_ENCODING()
 * @method $this setCURLOPT_EGDSOCKET()
 * @method $this setCURLOPT_DNS_USE_GLOBAL_CACHE()
 * @method $this setCURLOPT_DNS_SERVERS()
 * @method $this setCURLOPT_DNS_LOCAL_IP6()
 * @method $this setCURLOPT_DNS_LOCAL_IP4()
 * @method $this setCURLOPT_DNS_INTERFACE()
 * @method $this setCURLOPT_DNS_CACHE_TIMEOUT()
 * @method $this setCURLOPT_DIRLISTONLY()
 * @method $this setCURLOPT_CUSTOMREQUEST()
 * @method $this setCURLOPT_CRLFILE()
 * @method $this setCURLOPT_CRLF()
 * @method $this setCURLOPT_COOKIESESSION()
 * @method $this setCURLOPT_COOKIELIST()
 * @method $this setCURLOPT_COOKIEJAR()
 * @method $this setCURLOPT_COOKIEFILE()
 * @method $this setCURLOPT_COOKIE()
 * @method $this setCURLOPT_CONNECT_ONLY()
 * @method $this setCURLOPT_CONNECTTIMEOUT_MS()
 * @method $this setCURLOPT_CONNECTTIMEOUT()
 * @method $this setCURLOPT_CLOSEPOLICY()
 * @method $this setCURLOPT_CERTINFO()
 * @method $this setCURLOPT_CAPATH()
 * @method $this setCURLOPT_CAINFO()
 * @method $this setCURLOPT_BUFFERSIZE()
 * @method $this setCURLOPT_BINARYTRANSFER()
 * @method $this setCURLOPT_AUTOREFERER()
 * @method $this setCURLOPT_APPEND()
 * @method $this setCURLOPT_ADDRESS_SCOPE()
 * @method $this setCURLOPT_ACCEPT_ENCODING()
 * @method $this setCURLM_OUT_OF_MEMORY()
 * @method $this setCURLM_OK()
 * @method $this setCURLM_INTERNAL_ERROR()
 * @method $this setCURLM_CALL_MULTI_PERFORM()
 * @method $this setCURLM_BAD_HANDLE()
 * @method $this setCURLM_BAD_EASY_HANDLE()
 * @method $this setCURLMSG_DONE()
 * @method $this setCURLMOPT_PUSHFUNCTION()
 * @method $this setCURLMOPT_PIPELINING()
 * @method $this setCURLMOPT_MAX_TOTAL_CONNECTIONS()
 * @method $this setCURLMOPT_MAX_PIPELINE_LENGTH()
 * @method $this setCURLMOPT_MAX_HOST_CONNECTIONS()
 * @method $this setCURLMOPT_MAXCONNECTS()
 * @method $this setCURLMOPT_CONTENT_LENGTH_PENALTY_SIZE()
 * @method $this setCURLMOPT_CHUNK_LENGTH_PENALTY_SIZE()
 * @method $this setCURLINFO_TOTAL_TIME()
 * @method $this setCURLINFO_STARTTRANSFER_TIME()
 * @method $this setCURLINFO_SSL_VERIFYRESULT()
 * @method $this setCURLINFO_SSL_ENGINES()
 * @method $this setCURLINFO_SPEED_UPLOAD()
 * @method $this setCURLINFO_SPEED_DOWNLOAD()
 * @method $this setCURLINFO_SIZE_UPLOAD()
 * @method $this setCURLINFO_SIZE_DOWNLOAD()
 * @method $this setCURLINFO_RTSP_SESSION_ID()
 * @method $this setCURLINFO_RTSP_SERVER_CSEQ()
 * @method $this setCURLINFO_RTSP_CSEQ_RECV()
 * @method $this setCURLINFO_RTSP_CLIENT_CSEQ()
 * @method $this setCURLINFO_RESPONSE_CODE()
 * @method $this setCURLINFO_REQUEST_SIZE()
 * @method $this setCURLINFO_REDIRECT_URL()
 * @method $this setCURLINFO_REDIRECT_TIME()
 * @method $this setCURLINFO_REDIRECT_COUNT()
 * @method $this setCURLINFO_PROXYAUTH_AVAIL()
 * @method $this setCURLINFO_PRIVATE()
 * @method $this setCURLINFO_PRIMARY_PORT()
 * @method $this setCURLINFO_PRIMARY_IP()
 * @method $this setCURLINFO_PRETRANSFER_TIME()
 * @method $this setCURLINFO_OS_ERRNO()
 * @method $this setCURLINFO_NUM_CONNECTS()
 * @method $this setCURLINFO_NAMELOOKUP_TIME()
 * @method $this setCURLINFO_LOCAL_PORT()
 * @method $this setCURLINFO_LOCAL_IP()
 * @method $this setCURLINFO_HTTP_CONNECTCODE()
 * @method $this setCURLINFO_HTTP_CODE()
 * @method $this setCURLINFO_HTTPAUTH_AVAIL()
 * @method $this setCURLINFO_HEADER_SIZE()
 * @method $this setCURLINFO_HEADER_OUT()
 * @method $this setCURLINFO_FTP_ENTRY_PATH()
 * @method $this setCURLINFO_FILETIME()
 * @method $this setCURLINFO_EFFECTIVE_URL()
 * @method $this setCURLINFO_COOKIELIST()
 * @method $this setCURLINFO_CONTENT_TYPE()
 * @method $this setCURLINFO_CONTENT_LENGTH_UPLOAD()
 * @method $this setCURLINFO_CONTENT_LENGTH_DOWNLOAD()
 * @method $this setCURLINFO_CONNECT_TIME()
 * @method $this setCURLINFO_CONDITION_UNMET()
 * @method $this setCURLINFO_CERTINFO()
 * @method $this setCURLINFO_APPCONNECT_TIME()
 * @method $this setCURLHEADER_UNIFIED()
 * @method $this setCURLHEADER_SEPARATE()
 * @method $this setCURLFTP_CREATE_DIR_RETRY()
 * @method $this setCURLFTP_CREATE_DIR_NONE()
 * @method $this setCURLFTP_CREATE_DIR()
 * @method $this setCURLFTPSSL_TRY()
 * @method $this setCURLFTPSSL_NONE()
 * @method $this setCURLFTPSSL_CONTROL()
 * @method $this setCURLFTPSSL_ALL()
 * @method $this setCURLFTPMETHOD_SINGLECWD()
 * @method $this setCURLFTPMETHOD_NOCWD()
 * @method $this setCURLFTPMETHOD_MULTICWD()
 * @method $this setCURLFTPAUTH_TLS()
 * @method $this setCURLFTPAUTH_SSL()
 * @method $this setCURLFTPAUTH_DEFAULT()
 * @method $this setCURLE_WRITE_ERROR()
 * @method $this setCURLE_URL_MALFORMAT_USER()
 * @method $this setCURLE_URL_MALFORMAT()
 * @method $this setCURLE_UNSUPPORTED_PROTOCOL()
 * @method $this setCURLE_UNKNOWN_TELNET_OPTION()
 * @method $this setCURLE_TOO_MANY_REDIRECTS()
 * @method $this setCURLE_TELNET_OPTION_SYNTAX()
 * @method $this setCURLE_SSL_PEER_CERTIFICATE()
 * @method $this setCURLE_SSL_ENGINE_SETFAILED()
 * @method $this setCURLE_SSL_ENGINE_NOTFOUND()
 * @method $this setCURLE_SSL_CONNECT_ERROR()
 * @method $this setCURLE_SSL_CIPHER()
 * @method $this setCURLE_SSL_CERTPROBLEM()
 * @method $this setCURLE_SSL_CACERT()
 * @method $this setCURLE_SHARE_IN_USE()
 * @method $this setCURLE_SEND_ERROR()
 * @method $this setCURLE_RECV_ERROR()
 * @method $this setCURLE_READ_ERROR()
 * @method $this setCURLE_PARTIAL_FILE()
 * @method $this setCURLE_OUT_OF_MEMORY()
 * @method $this setCURLE_OPERATION_TIMEOUTED()
 * @method $this setCURLE_OK()
 * @method $this setCURLE_OBSOLETE()
 * @method $this setCURLE_MALFORMAT_USER()
 * @method $this setCURLE_LIBRARY_NOT_FOUND()
 * @method $this setCURLE_LDAP_SEARCH_FAILED()
 * @method $this setCURLE_LDAP_INVALID_URL()
 * @method $this setCURLE_LDAP_CANNOT_BIND()
 * @method $this setCURLE_HTTP_RANGE_ERROR()
 * @method $this setCURLE_HTTP_POST_ERROR()
 * @method $this setCURLE_HTTP_PORT_FAILED()
 * @method $this setCURLE_HTTP_NOT_FOUND()
 * @method $this setCURLE_GOT_NOTHING()
 * @method $this setCURLE_FUNCTION_NOT_FOUND()
 * @method $this setCURLE_FTP_WRITE_ERROR()
 * @method $this setCURLE_FTP_WEIRD_USER_REPLY()
 * @method $this setCURLE_FTP_WEIRD_SERVER_REPLY()
 * @method $this setCURLE_FTP_WEIRD_PASV_REPLY()
 * @method $this setCURLE_FTP_WEIRD_PASS_REPLY()
 * @method $this setCURLE_FTP_WEIRD_227_FORMAT()
 * @method $this setCURLE_FTP_USER_PASSWORD_INCORRECT()
 * @method $this setCURLE_FTP_SSL_FAILED()
 * @method $this setCURLE_FTP_QUOTE_ERROR()
 * @method $this setCURLE_FTP_PORT_FAILED()
 * @method $this setCURLE_FTP_COULDNT_USE_REST()
 * @method $this setCURLE_FTP_COULDNT_STOR_FILE()
 * @method $this setCURLE_FTP_COULDNT_SET_BINARY()
 * @method $this setCURLE_FTP_COULDNT_SET_ASCII()
 * @method $this setCURLE_FTP_COULDNT_RETR_FILE()
 * @method $this setCURLE_FTP_COULDNT_GET_SIZE()
 * @method $this setCURLE_FTP_CANT_RECONNECT()
 * @method $this setCURLE_FTP_CANT_GET_HOST()
 * @method $this setCURLE_FTP_BAD_DOWNLOAD_RESUME()
 * @method $this setCURLE_FTP_ACCESS_DENIED()
 * @method $this setCURLE_FILE_COULDNT_READ_FILE()
 * @method $this setCURLE_FILESIZE_EXCEEDED()
 * @method $this setCURLE_FAILED_INIT()
 * @method $this setCURLE_COULDNT_RESOLVE_PROXY()
 * @method $this setCURLE_COULDNT_RESOLVE_HOST()
 * @method $this setCURLE_COULDNT_CONNECT()
 * @method $this setCURLE_BAD_PASSWORD_ENTERED()
 * @method $this setCURLE_BAD_FUNCTION_ARGUMENT()
 * @method $this setCURLE_BAD_CONTENT_ENCODING()
 * @method $this setCURLE_BAD_CALLING_ORDER()
 * @method $this setCURLE_ABORTED_BY_CALLBACK()
 * @method $this setCURLCLOSEPOLICY_SLOWEST()
 * @method $this setCURLCLOSEPOLICY_OLDEST()
 * @method $this setCURLCLOSEPOLICY_LEAST_TRAFFIC()
 * @method $this setCURLCLOSEPOLICY_LEAST_RECENTLY_USED()
 * @method $this setCURLCLOSEPOLICY_CALLBACK()
 * @method $this setCURLAUTH_NTLM_WB()
 * @method $this setCURLAUTH_NTLM()
 * @method $this setCURLAUTH_NEGOTIATE()
 * @method $this setCURLAUTH_GSSNEGOTIATE()
 * @method $this setCURLAUTH_DIGEST()
 * @method $this setCURLAUTH_BASIC()
 * @method $this setCURLAUTH_ANYSAFE()
 * @method $this setCURLAUTH_ANY()
 *
 * @method $this getCURL_VERSION_SSL()
 * @method $this getCURL_VERSION_LIBZ()
 * @method $this getCURL_VERSION_KERBEROS4()
 * @method $this getCURL_VERSION_IPV6()
 * @method $this getCURL_TIMECOND_LASTMOD()
 * @method $this getCURL_TIMECOND_IFUNMODSINCE()
 * @method $this getCURL_TIMECOND_IFMODSINCE()
 * @method $this getCURL_SSLVERSION_TLSv1_2()
 * @method $this getCURL_SSLVERSION_TLSv1_1()
 * @method $this getCURL_SSLVERSION_TLSv1_0()
 * @method $this getCURL_SSLVERSION_TLSv1()
 * @method $this getCURL_SSLVERSION_SSLv3()
 * @method $this getCURL_SSLVERSION_SSLv2()
 * @method $this getCURL_SSLVERSION_DEFAULT()
 * @method $this getCURL_REDIR_POST_ALL()
 * @method $this getCURL_REDIR_POST_303()
 * @method $this getCURL_REDIR_POST_302()
 * @method $this getCURL_REDIR_POST_301()
 * @method $this getCURL_PUSH_OK()
 * @method $this getCURL_PUSH_DENY()
 * @method $this getCURL_NETRC_REQUIRED()
 * @method $this getCURL_NETRC_OPTIONAL()
 * @method $this getCURL_NETRC_IGNORED()
 * @method $this getCURL_LOCK_DATA_SSL_SESSION()
 * @method $this getCURL_LOCK_DATA_DNS()
 * @method $this getCURL_LOCK_DATA_COOKIE()
 * @method $this getCURL_IPRESOLVE_WHATEVER()
 * @method $this getCURL_IPRESOLVE_V6()
 * @method $this getCURL_IPRESOLVE_V4()
 * @method $this getCURL_HTTP_VERSION_NONE()
 * @method $this getCURL_HTTP_VERSION_2_PRIOR_KNOWLEDGE()
 * @method $this getCURL_HTTP_VERSION_2_0()
 * @method $this getCURL_HTTP_VERSION_2TLS()
 * @method $this getCURL_HTTP_VERSION_2()
 * @method $this getCURL_HTTP_VERSION_1_1()
 * @method $this getCURL_HTTP_VERSION_1_0()
 * @method $this getCURLVERSION_NOW()
 * @method $this getCURLSSH_AUTH_AGENT()
 * @method $this getCURLSHOPT_UNSHARE()
 * @method $this getCURLSHOPT_SHARE()
 * @method $this getCURLPROXY_SOCKS5()
 * @method $this getCURLPROXY_SOCKS4()
 * @method $this getCURLPROXY_HTTP_1_0()
 * @method $this getCURLPROXY_HTTP()
 * @method $this getCURLPROTO_TFTP()
 * @method $this getCURLPROTO_TELNET()
 * @method $this getCURLPROTO_SMBS()
 * @method $this getCURLPROTO_SMB()
 * @method $this getCURLPROTO_SFTP()
 * @method $this getCURLPROTO_SCP()
 * @method $this getCURLPROTO_LDAPS()
 * @method $this getCURLPROTO_LDAP()
 * @method $this getCURLPROTO_HTTPS()
 * @method $this getCURLPROTO_HTTP()
 * @method $this getCURLPROTO_FTPS()
 * @method $this getCURLPROTO_FTP()
 * @method $this getCURLPROTO_FILE()
 * @method $this getCURLPROTO_DICT()
 * @method $this getCURLPROTO_ALL()
 * @method $this getCURLPIPE_NOTHING()
 * @method $this getCURLPIPE_MULTIPLEX()
 * @method $this getCURLPIPE_HTTP1()
 * @method $this getCURLOPT_XOAUTH2_BEARER()
 * @method $this getCURLOPT_WRITEHEADER()
 * @method $this getCURLOPT_WRITEFUNCTION()
 * @method $this getCURLOPT_VERBOSE()
 * @method $this getCURLOPT_USE_SSL()
 * @method $this getCURLOPT_USERPWD()
 * @method $this getCURLOPT_USERNAME()
 * @method $this getCURLOPT_USERAGENT()
 * @method $this getCURLOPT_URL()
 * @method $this getCURLOPT_UPLOAD()
 * @method $this getCURLOPT_UNRESTRICTED_AUTH()
 * @method $this getCURLOPT_UNIX_SOCKET_PATH()
 * @method $this getCURLOPT_TRANSFER_ENCODING()
 * @method $this getCURLOPT_TRANSFERTEXT()
 * @method $this getCURLOPT_TIMEVALUE()
 * @method $this getCURLOPT_TIMEOUT_MS()
 * @method $this getCURLOPT_TIMEOUT()
 * @method $this getCURLOPT_TIMECONDITION()
 * @method $this getCURLOPT_TFTP_BLKSIZE()
 * @method $this getCURLOPT_TCP_NODELAY()
 * @method $this getCURLOPT_STDERR()
 * @method $this getCURLOPT_SSL_VERIFYSTATUS()
 * @method $this getCURLOPT_SSL_VERIFYPEER()
 * @method $this getCURLOPT_SSL_VERIFYHOST()
 * @method $this getCURLOPT_SSL_SESSIONID_CACHE()
 * @method $this getCURLOPT_SSL_FALSESTART()
 * @method $this getCURLOPT_SSL_ENABLE_NPN()
 * @method $this getCURLOPT_SSL_ENABLE_ALPN()
 * @method $this getCURLOPT_SSL_CIPHER_LIST()
 * @method $this getCURLOPT_SSLVERSION()
 * @method $this getCURLOPT_SSLKEYTYPE()
 * @method $this getCURLOPT_SSLKEYPASSWD()
 * @method $this getCURLOPT_SSLKEY()
 * @method $this getCURLOPT_SSLENGINE_DEFAULT()
 * @method $this getCURLOPT_SSLENGINE()
 * @method $this getCURLOPT_SSLCERTTYPE()
 * @method $this getCURLOPT_SSLCERTPASSWD()
 * @method $this getCURLOPT_SSLCERT()
 * @method $this getCURLOPT_SSH_PUBLIC_KEYFILE()
 * @method $this getCURLOPT_SSH_PRIVATE_KEYFILE()
 * @method $this getCURLOPT_SSH_KNOWNHOSTS()
 * @method $this getCURLOPT_SSH_HOST_PUBLIC_KEY_MD5()
 * @method $this getCURLOPT_SSH_AUTH_TYPES()
 * @method $this getCURLOPT_SOCKS5_GSSAPI_SERVICE()
 * @method $this getCURLOPT_SOCKS5_GSSAPI_NEC()
 * @method $this getCURLOPT_SHARE()
 * @method $this getCURLOPT_SERVICE_NAME()
 * @method $this getCURLOPT_SASL_IR()
 * @method $this getCURLOPT_SAFE_UPLOAD()
 * @method $this getCURLOPT_RTSP_TRANSPORT()
 * @method $this getCURLOPT_RTSP_STREAM_URI()
 * @method $this getCURLOPT_RTSP_SESSION_ID()
 * @method $this getCURLOPT_RTSP_SERVER_CSEQ()
 * @method $this getCURLOPT_RTSP_REQUEST()
 * @method $this getCURLOPT_RTSP_CLIENT_CSEQ()
 * @method $this getCURLOPT_RETURNTRANSFER()
 * @method $this getCURLOPT_RESUME_FROM()
 * @method $this getCURLOPT_RESOLVE()
 * @method $this getCURLOPT_REFERER()
 * @method $this getCURLOPT_REDIR_PROTOCOLS()
 * @method $this getCURLOPT_READFUNCTION()
 * @method $this getCURLOPT_READDATA()
 * @method $this getCURLOPT_RANGE()
 * @method $this getCURLOPT_RANDOM_FILE()
 * @method $this getCURLOPT_QUOTE()
 * @method $this getCURLOPT_PUT()
 * @method $this getCURLOPT_PROXY_TRANSFER_MODE()
 * @method $this getCURLOPT_PROXY_SERVICE_NAME()
 * @method $this getCURLOPT_PROXYUSERPWD()
 * @method $this getCURLOPT_PROXYUSERNAME()
 * @method $this getCURLOPT_PROXYTYPE()
 * @method $this getCURLOPT_PROXYPORT()
 * @method $this getCURLOPT_PROXYPASSWORD()
 * @method $this getCURLOPT_PROXYHEADER()
 * @method $this getCURLOPT_PROXYAUTH()
 * @method $this getCURLOPT_PROXY()
 * @method $this getCURLOPT_PROTOCOLS()
 * @method $this getCURLOPT_PROGRESSFUNCTION()
 * @method $this getCURLOPT_PRIVATE()
 * @method $this getCURLOPT_PREQUOTE()
 * @method $this getCURLOPT_POSTREDIR()
 * @method $this getCURLOPT_POSTQUOTE()
 * @method $this getCURLOPT_POSTFIELDS()
 * @method $this getCURLOPT_POST()
 * @method $this getCURLOPT_PORT()
 * @method $this getCURLOPT_PIPEWAIT()
 * @method $this getCURLOPT_PINNEDPUBLICKEY()
 * @method $this getCURLOPT_PATH_AS_IS()
 * @method $this getCURLOPT_PASSWORD()
 * @method $this getCURLOPT_PASSWDFUNCTION()
 * @method $this getCURLOPT_NOSIGNAL()
 * @method $this getCURLOPT_NOPROXY()
 * @method $this getCURLOPT_NOPROGRESS()
 * @method $this getCURLOPT_NOBODY()
 * @method $this getCURLOPT_NEW_FILE_PERMS()
 * @method $this getCURLOPT_NEW_DIRECTORY_PERMS()
 * @method $this getCURLOPT_NETRC_FILE()
 * @method $this getCURLOPT_NETRC()
 * @method $this getCURLOPT_MUTE()
 * @method $this getCURLOPT_MAX_SEND_SPEED_LARGE()
 * @method $this getCURLOPT_MAX_RECV_SPEED_LARGE()
 * @method $this getCURLOPT_MAXREDIRS()
 * @method $this getCURLOPT_MAXFILESIZE()
 * @method $this getCURLOPT_MAXCONNECTS()
 * @method $this getCURLOPT_MAIL_RCPT()
 * @method $this getCURLOPT_MAIL_FROM()
 * @method $this getCURLOPT_LOW_SPEED_TIME()
 * @method $this getCURLOPT_LOW_SPEED_LIMIT()
 * @method $this getCURLOPT_LOGIN_OPTIONS()
 * @method $this getCURLOPT_LOCALPORTRANGE()
 * @method $this getCURLOPT_LOCALPORT()
 * @method $this getCURLOPT_KRBLEVEL()
 * @method $this getCURLOPT_KRB4LEVEL()
 * @method $this getCURLOPT_KEYPASSWD()
 * @method $this getCURLOPT_ISSUERCERT()
 * @method $this getCURLOPT_IPRESOLVE()
 * @method $this getCURLOPT_INTERFACE()
 * @method $this getCURLOPT_INFILESIZE()
 * @method $this getCURLOPT_INFILE()
 * @method $this getCURLOPT_IGNORE_CONTENT_LENGTH()
 * @method $this getCURLOPT_HTTP_VERSION()
 * @method $this getCURLOPT_HTTP_TRANSFER_DECODING()
 * @method $this getCURLOPT_HTTP_CONTENT_DECODING()
 * @method $this getCURLOPT_HTTPPROXYTUNNEL()
 * @method $this getCURLOPT_HTTPHEADER()
 * @method $this getCURLOPT_HTTPGET()
 * @method $this getCURLOPT_HTTPAUTH()
 * @method $this getCURLOPT_HTTP200ALIASES()
 * @method $this getCURLOPT_HEADEROPT()
 * @method $this getCURLOPT_HEADERFUNCTION()
 * @method $this getCURLOPT_HEADER()
 * @method $this getCURLOPT_FTP_USE_PRET()
 * @method $this getCURLOPT_FTP_USE_EPSV()
 * @method $this getCURLOPT_FTP_USE_EPRT()
 * @method $this getCURLOPT_FTP_SSL_CCC()
 * @method $this getCURLOPT_FTP_SSL()
 * @method $this getCURLOPT_FTP_SKIP_PASV_IP()
 * @method $this getCURLOPT_FTP_RESPONSE_TIMEOUT()
 * @method $this getCURLOPT_FTP_FILEMETHOD()
 * @method $this getCURLOPT_FTP_CREATE_MISSING_DIRS()
 * @method $this getCURLOPT_FTP_ALTERNATIVE_TO_USER()
 * @method $this getCURLOPT_FTP_ACCOUNT()
 * @method $this getCURLOPT_FTPSSLAUTH()
 * @method $this getCURLOPT_FTPPORT()
 * @method $this getCURLOPT_FTPLISTONLY()
 * @method $this getCURLOPT_FTPASCII()
 * @method $this getCURLOPT_FTPAPPEND()
 * @method $this getCURLOPT_FRESH_CONNECT()
 * @method $this getCURLOPT_FORBID_REUSE()
 * @method $this getCURLOPT_FOLLOWLOCATION()
 * @method $this getCURLOPT_FILETIME()
 * @method $this getCURLOPT_FILE()
 * @method $this getCURLOPT_FAILONERROR()
 * @method $this getCURLOPT_EXPECT_100_TIMEOUT_MS()
 * @method $this getCURLOPT_ENCODING()
 * @method $this getCURLOPT_EGDSOCKET()
 * @method $this getCURLOPT_DNS_USE_GLOBAL_CACHE()
 * @method $this getCURLOPT_DNS_SERVERS()
 * @method $this getCURLOPT_DNS_LOCAL_IP6()
 * @method $this getCURLOPT_DNS_LOCAL_IP4()
 * @method $this getCURLOPT_DNS_INTERFACE()
 * @method $this getCURLOPT_DNS_CACHE_TIMEOUT()
 * @method $this getCURLOPT_DIRLISTONLY()
 * @method $this getCURLOPT_CUSTOMREQUEST()
 * @method $this getCURLOPT_CRLFILE()
 * @method $this getCURLOPT_CRLF()
 * @method $this getCURLOPT_COOKIESESSION()
 * @method $this getCURLOPT_COOKIELIST()
 * @method $this getCURLOPT_COOKIEJAR()
 * @method $this getCURLOPT_COOKIEFILE()
 * @method $this getCURLOPT_COOKIE()
 * @method $this getCURLOPT_CONNECT_ONLY()
 * @method $this getCURLOPT_CONNECTTIMEOUT_MS()
 * @method $this getCURLOPT_CONNECTTIMEOUT()
 * @method $this getCURLOPT_CLOSEPOLICY()
 * @method $this getCURLOPT_CERTINFO()
 * @method $this getCURLOPT_CAPATH()
 * @method $this getCURLOPT_CAINFO()
 * @method $this getCURLOPT_BUFFERSIZE()
 * @method $this getCURLOPT_BINARYTRANSFER()
 * @method $this getCURLOPT_AUTOREFERER()
 * @method $this getCURLOPT_APPEND()
 * @method $this getCURLOPT_ADDRESS_SCOPE()
 * @method $this getCURLOPT_ACCEPT_ENCODING()
 * @method $this getCURLM_OUT_OF_MEMORY()
 * @method $this getCURLM_OK()
 * @method $this getCURLM_INTERNAL_ERROR()
 * @method $this getCURLM_CALL_MULTI_PERFORM()
 * @method $this getCURLM_BAD_HANDLE()
 * @method $this getCURLM_BAD_EASY_HANDLE()
 * @method $this getCURLMSG_DONE()
 * @method $this getCURLMOPT_PUSHFUNCTION()
 * @method $this getCURLMOPT_PIPELINING()
 * @method $this getCURLMOPT_MAX_TOTAL_CONNECTIONS()
 * @method $this getCURLMOPT_MAX_PIPELINE_LENGTH()
 * @method $this getCURLMOPT_MAX_HOST_CONNECTIONS()
 * @method $this getCURLMOPT_MAXCONNECTS()
 * @method $this getCURLMOPT_CONTENT_LENGTH_PENALTY_SIZE()
 * @method $this getCURLMOPT_CHUNK_LENGTH_PENALTY_SIZE()
 * @method $this getCURLINFO_TOTAL_TIME()
 * @method $this getCURLINFO_STARTTRANSFER_TIME()
 * @method $this getCURLINFO_SSL_VERIFYRESULT()
 * @method $this getCURLINFO_SSL_ENGINES()
 * @method $this getCURLINFO_SPEED_UPLOAD()
 * @method $this getCURLINFO_SPEED_DOWNLOAD()
 * @method $this getCURLINFO_SIZE_UPLOAD()
 * @method $this getCURLINFO_SIZE_DOWNLOAD()
 * @method $this getCURLINFO_RTSP_SESSION_ID()
 * @method $this getCURLINFO_RTSP_SERVER_CSEQ()
 * @method $this getCURLINFO_RTSP_CSEQ_RECV()
 * @method $this getCURLINFO_RTSP_CLIENT_CSEQ()
 * @method $this getCURLINFO_RESPONSE_CODE()
 * @method $this getCURLINFO_REQUEST_SIZE()
 * @method $this getCURLINFO_REDIRECT_URL()
 * @method $this getCURLINFO_REDIRECT_TIME()
 * @method $this getCURLINFO_REDIRECT_COUNT()
 * @method $this getCURLINFO_PROXYAUTH_AVAIL()
 * @method $this getCURLINFO_PRIVATE()
 * @method $this getCURLINFO_PRIMARY_PORT()
 * @method $this getCURLINFO_PRIMARY_IP()
 * @method $this getCURLINFO_PRETRANSFER_TIME()
 * @method $this getCURLINFO_OS_ERRNO()
 * @method $this getCURLINFO_NUM_CONNECTS()
 * @method $this getCURLINFO_NAMELOOKUP_TIME()
 * @method $this getCURLINFO_LOCAL_PORT()
 * @method $this getCURLINFO_LOCAL_IP()
 * @method $this getCURLINFO_HTTP_CONNECTCODE()
 * @method $this getCURLINFO_HTTP_CODE()
 * @method $this getCURLINFO_HTTPAUTH_AVAIL()
 * @method $this getCURLINFO_HEADER_SIZE()
 * @method $this getCURLINFO_HEADER_OUT()
 * @method $this getCURLINFO_FTP_ENTRY_PATH()
 * @method $this getCURLINFO_FILETIME()
 * @method $this getCURLINFO_EFFECTIVE_URL()
 * @method $this getCURLINFO_COOKIELIST()
 * @method $this getCURLINFO_CONTENT_TYPE()
 * @method $this getCURLINFO_CONTENT_LENGTH_UPLOAD()
 * @method $this getCURLINFO_CONTENT_LENGTH_DOWNLOAD()
 * @method $this getCURLINFO_CONNECT_TIME()
 * @method $this getCURLINFO_CONDITION_UNMET()
 * @method $this getCURLINFO_CERTINFO()
 * @method $this getCURLINFO_APPCONNECT_TIME()
 * @method $this getCURLHEADER_UNIFIED()
 * @method $this getCURLHEADER_SEPARATE()
 * @method $this getCURLFTP_CREATE_DIR_RETRY()
 * @method $this getCURLFTP_CREATE_DIR_NONE()
 * @method $this getCURLFTP_CREATE_DIR()
 * @method $this getCURLFTPSSL_TRY()
 * @method $this getCURLFTPSSL_NONE()
 * @method $this getCURLFTPSSL_CONTROL()
 * @method $this getCURLFTPSSL_ALL()
 * @method $this getCURLFTPMETHOD_SINGLECWD()
 * @method $this getCURLFTPMETHOD_NOCWD()
 * @method $this getCURLFTPMETHOD_MULTICWD()
 * @method $this getCURLFTPAUTH_TLS()
 * @method $this getCURLFTPAUTH_SSL()
 * @method $this getCURLFTPAUTH_DEFAULT()
 * @method $this getCURLE_WRITE_ERROR()
 * @method $this getCURLE_URL_MALFORMAT_USER()
 * @method $this getCURLE_URL_MALFORMAT()
 * @method $this getCURLE_UNSUPPORTED_PROTOCOL()
 * @method $this getCURLE_UNKNOWN_TELNET_OPTION()
 * @method $this getCURLE_TOO_MANY_REDIRECTS()
 * @method $this getCURLE_TELNET_OPTION_SYNTAX()
 * @method $this getCURLE_SSL_PEER_CERTIFICATE()
 * @method $this getCURLE_SSL_ENGINE_SETFAILED()
 * @method $this getCURLE_SSL_ENGINE_NOTFOUND()
 * @method $this getCURLE_SSL_CONNECT_ERROR()
 * @method $this getCURLE_SSL_CIPHER()
 * @method $this getCURLE_SSL_CERTPROBLEM()
 * @method $this getCURLE_SSL_CACERT()
 * @method $this getCURLE_SHARE_IN_USE()
 * @method $this getCURLE_SEND_ERROR()
 * @method $this getCURLE_RECV_ERROR()
 * @method $this getCURLE_READ_ERROR()
 * @method $this getCURLE_PARTIAL_FILE()
 * @method $this getCURLE_OUT_OF_MEMORY()
 * @method $this getCURLE_OPERATION_TIMEOUTED()
 * @method $this getCURLE_OK()
 * @method $this getCURLE_OBSOLETE()
 * @method $this getCURLE_MALFORMAT_USER()
 * @method $this getCURLE_LIBRARY_NOT_FOUND()
 * @method $this getCURLE_LDAP_SEARCH_FAILED()
 * @method $this getCURLE_LDAP_INVALID_URL()
 * @method $this getCURLE_LDAP_CANNOT_BIND()
 * @method $this getCURLE_HTTP_RANGE_ERROR()
 * @method $this getCURLE_HTTP_POST_ERROR()
 * @method $this getCURLE_HTTP_PORT_FAILED()
 * @method $this getCURLE_HTTP_NOT_FOUND()
 * @method $this getCURLE_GOT_NOTHING()
 * @method $this getCURLE_FUNCTION_NOT_FOUND()
 * @method $this getCURLE_FTP_WRITE_ERROR()
 * @method $this getCURLE_FTP_WEIRD_USER_REPLY()
 * @method $this getCURLE_FTP_WEIRD_SERVER_REPLY()
 * @method $this getCURLE_FTP_WEIRD_PASV_REPLY()
 * @method $this getCURLE_FTP_WEIRD_PASS_REPLY()
 * @method $this getCURLE_FTP_WEIRD_227_FORMAT()
 * @method $this getCURLE_FTP_USER_PASSWORD_INCORRECT()
 * @method $this getCURLE_FTP_SSL_FAILED()
 * @method $this getCURLE_FTP_QUOTE_ERROR()
 * @method $this getCURLE_FTP_PORT_FAILED()
 * @method $this getCURLE_FTP_COULDNT_USE_REST()
 * @method $this getCURLE_FTP_COULDNT_STOR_FILE()
 * @method $this getCURLE_FTP_COULDNT_SET_BINARY()
 * @method $this getCURLE_FTP_COULDNT_SET_ASCII()
 * @method $this getCURLE_FTP_COULDNT_RETR_FILE()
 * @method $this getCURLE_FTP_COULDNT_GET_SIZE()
 * @method $this getCURLE_FTP_CANT_RECONNECT()
 * @method $this getCURLE_FTP_CANT_GET_HOST()
 * @method $this getCURLE_FTP_BAD_DOWNLOAD_RESUME()
 * @method $this getCURLE_FTP_ACCESS_DENIED()
 * @method $this getCURLE_FILE_COULDNT_READ_FILE()
 * @method $this getCURLE_FILESIZE_EXCEEDED()
 * @method $this getCURLE_FAILED_INIT()
 * @method $this getCURLE_COULDNT_RESOLVE_PROXY()
 * @method $this getCURLE_COULDNT_RESOLVE_HOST()
 * @method $this getCURLE_COULDNT_CONNECT()
 * @method $this getCURLE_BAD_PASSWORD_ENTERED()
 * @method $this getCURLE_BAD_FUNCTION_ARGUMENT()
 * @method $this getCURLE_BAD_CONTENT_ENCODING()
 * @method $this getCURLE_BAD_CALLING_ORDER()
 * @method $this getCURLE_ABORTED_BY_CALLBACK()
 * @method $this getCURLCLOSEPOLICY_SLOWEST()
 * @method $this getCURLCLOSEPOLICY_OLDEST()
 * @method $this getCURLCLOSEPOLICY_LEAST_TRAFFIC()
 * @method $this getCURLCLOSEPOLICY_LEAST_RECENTLY_USED()
 * @method $this getCURLCLOSEPOLICY_CALLBACK()
 * @method $this getCURLAUTH_NTLM_WB()
 * @method $this getCURLAUTH_NTLM()
 * @method $this getCURLAUTH_NEGOTIATE()
 * @method $this getCURLAUTH_GSSNEGOTIATE()
 * @method $this getCURLAUTH_DIGEST()
 * @method $this getCURLAUTH_BASIC()
 * @method $this getCURLAUTH_ANYSAFE()
 * @method $this getCURLAUTH_ANY()
 *
 * @package Zilf\Curl
 */

class Client
{
    private $config = [];

    private $curlOptions = [
        'CURL_VERSION_SSL' => 4,
        'CURL_VERSION_LIBZ' => 8,
        'CURL_VERSION_KERBEROS4' => 2,
        'CURL_VERSION_IPV6' => 1,
        'CURL_TIMECOND_LASTMOD' => 3,
        'CURL_TIMECOND_IFUNMODSINCE' => 2,
        'CURL_TIMECOND_IFMODSINCE' => 1,
        'CURL_SSLVERSION_TLSv1_2' => 6,
        'CURL_SSLVERSION_TLSv1_1' => 5,
        'CURL_SSLVERSION_TLSv1_0' => 4,
        'CURL_SSLVERSION_TLSv1' => 1,
        'CURL_SSLVERSION_SSLv3' => 3,
        'CURL_SSLVERSION_SSLv2' => 2,
        'CURL_SSLVERSION_DEFAULT' => 0,
        'CURL_REDIR_POST_ALL' => 7,
        'CURL_REDIR_POST_303' => 4,
        'CURL_REDIR_POST_302' => 2,
        'CURL_REDIR_POST_301' => 1,
        'CURL_PUSH_OK' => 0,
        'CURL_PUSH_DENY' => 1,
        'CURL_NETRC_REQUIRED' => 2,
        'CURL_NETRC_OPTIONAL' => 1,
        'CURL_NETRC_IGNORED' => 0,
        'CURL_LOCK_DATA_SSL_SESSION' => 4,
        'CURL_LOCK_DATA_DNS' => 3,
        'CURL_LOCK_DATA_COOKIE' => 2,
        'CURL_IPRESOLVE_WHATEVER' => 0,
        'CURL_IPRESOLVE_V6' => 2,
        'CURL_IPRESOLVE_V4' => 1,
        'CURL_HTTP_VERSION_NONE' => 0,
        'CURL_HTTP_VERSION_2_PRIOR_KNOWLEDGE' => 5,
        'CURL_HTTP_VERSION_2_0' => 3,
        'CURL_HTTP_VERSION_2TLS' => 4,
        'CURL_HTTP_VERSION_2' => 3,
        'CURL_HTTP_VERSION_1_1' => 2,
        'CURL_HTTP_VERSION_1_0' => 1,
        'CURLVERSION_NOW' => 3,
        'CURLSSH_AUTH_AGENT' => 16,
        'CURLSHOPT_UNSHARE' => 2,
        'CURLSHOPT_SHARE' => 1,
        'CURLPROXY_SOCKS5' => 5,
        'CURLPROXY_SOCKS4' => 4,
        'CURLPROXY_HTTP_1_0' => 1,
        'CURLPROXY_HTTP' => 0,
        'CURLPROTO_TFTP' => 2048,
        'CURLPROTO_TELNET' => 64,
        'CURLPROTO_SMBS' => 134217728,
        'CURLPROTO_SMB' => 67108864,
        'CURLPROTO_SFTP' => 32,
        'CURLPROTO_SCP' => 16,
        'CURLPROTO_LDAPS' => 256,
        'CURLPROTO_LDAP' => 128,
        'CURLPROTO_HTTPS' => 2,
        'CURLPROTO_HTTP' => 1,
        'CURLPROTO_FTPS' => 8,
        'CURLPROTO_FTP' => 4,
        'CURLPROTO_FILE' => 1024,
        'CURLPROTO_DICT' => 512,
        'CURLPROTO_ALL' => -1,
        'CURLPIPE_NOTHING' => 0,
        'CURLPIPE_MULTIPLEX' => 2,
        'CURLPIPE_HTTP1' => 1,
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
        'CURLM_OUT_OF_MEMORY' => 3,
        'CURLM_OK' => 0,
        'CURLM_INTERNAL_ERROR' => 4,
        'CURLM_CALL_MULTI_PERFORM' => -1,
        'CURLM_BAD_HANDLE' => 1,
        'CURLM_BAD_EASY_HANDLE' => 2,
        'CURLMSG_DONE' => 1,
        'CURLMOPT_PUSHFUNCTION' => 20014,
        'CURLMOPT_PIPELINING' => 3,
        'CURLMOPT_MAX_TOTAL_CONNECTIONS' => 13,
        'CURLMOPT_MAX_PIPELINE_LENGTH' => 8,
        'CURLMOPT_MAX_HOST_CONNECTIONS' => 7,
        'CURLMOPT_MAXCONNECTS' => 6,
        'CURLMOPT_CONTENT_LENGTH_PENALTY_SIZE' => 30009,
        'CURLMOPT_CHUNK_LENGTH_PENALTY_SIZE' => 30010,
        'CURLINFO_TOTAL_TIME' => 3145731,
        'CURLINFO_STARTTRANSFER_TIME' => 3145745,
        'CURLINFO_SSL_VERIFYRESULT' => 2097165,
        'CURLINFO_SSL_ENGINES' => 4194331,
        'CURLINFO_SPEED_UPLOAD' => 3145738,
        'CURLINFO_SPEED_DOWNLOAD' => 3145737,
        'CURLINFO_SIZE_UPLOAD' => 3145735,
        'CURLINFO_SIZE_DOWNLOAD' => 3145736,
        'CURLINFO_RTSP_SESSION_ID' => 1048612,
        'CURLINFO_RTSP_SERVER_CSEQ' => 2097190,
        'CURLINFO_RTSP_CSEQ_RECV' => 2097191,
        'CURLINFO_RTSP_CLIENT_CSEQ' => 2097189,
        'CURLINFO_RESPONSE_CODE' => 2097154,
        'CURLINFO_REQUEST_SIZE' => 2097164,
        'CURLINFO_REDIRECT_URL' => 1048607,
        'CURLINFO_REDIRECT_TIME' => 3145747,
        'CURLINFO_REDIRECT_COUNT' => 2097172,
        'CURLINFO_PROXYAUTH_AVAIL' => 2097176,
        'CURLINFO_PRIVATE' => 1048597,
        'CURLINFO_PRIMARY_PORT' => 2097192,
        'CURLINFO_PRIMARY_IP' => 1048608,
        'CURLINFO_PRETRANSFER_TIME' => 3145734,
        'CURLINFO_OS_ERRNO' => 2097177,
        'CURLINFO_NUM_CONNECTS' => 2097178,
        'CURLINFO_NAMELOOKUP_TIME' => 3145732,
        'CURLINFO_LOCAL_PORT' => 2097194,
        'CURLINFO_LOCAL_IP' => 1048617,
        'CURLINFO_HTTP_CONNECTCODE' => 2097174,
        'CURLINFO_HTTP_CODE' => 2097154,
        'CURLINFO_HTTPAUTH_AVAIL' => 2097175,
        'CURLINFO_HEADER_SIZE' => 2097163,
        'CURLINFO_HEADER_OUT' => 2,
        'CURLINFO_FTP_ENTRY_PATH' => 1048606,
        'CURLINFO_FILETIME' => 2097166,
        'CURLINFO_EFFECTIVE_URL' => 1048577,
        'CURLINFO_COOKIELIST' => 4194332,
        'CURLINFO_CONTENT_TYPE' => 1048594,
        'CURLINFO_CONTENT_LENGTH_UPLOAD' => 3145744,
        'CURLINFO_CONTENT_LENGTH_DOWNLOAD' => 3145743,
        'CURLINFO_CONNECT_TIME' => 3145733,
        'CURLINFO_CONDITION_UNMET' => 2097187,
        'CURLINFO_CERTINFO' => 4194338,
        'CURLINFO_APPCONNECT_TIME' => 3145761,
        'CURLHEADER_UNIFIED' => 0,
        'CURLHEADER_SEPARATE' => 1,
        'CURLFTP_CREATE_DIR_RETRY' => 2,
        'CURLFTP_CREATE_DIR_NONE' => 0,
        'CURLFTP_CREATE_DIR' => 1,
        'CURLFTPSSL_TRY' => 1,
        'CURLFTPSSL_NONE' => 0,
        'CURLFTPSSL_CONTROL' => 2,
        'CURLFTPSSL_ALL' => 3,
        'CURLFTPMETHOD_SINGLECWD' => 3,
        'CURLFTPMETHOD_NOCWD' => 2,
        'CURLFTPMETHOD_MULTICWD' => 1,
        'CURLFTPAUTH_TLS' => 2,
        'CURLFTPAUTH_SSL' => 1,
        'CURLFTPAUTH_DEFAULT' => 0,
        'CURLE_WRITE_ERROR' => 23,
        'CURLE_URL_MALFORMAT_USER' => 4,
        'CURLE_URL_MALFORMAT' => 3,
        'CURLE_UNSUPPORTED_PROTOCOL' => 1,
        'CURLE_UNKNOWN_TELNET_OPTION' => 48,
        'CURLE_TOO_MANY_REDIRECTS' => 47,
        'CURLE_TELNET_OPTION_SYNTAX' => 49,
        'CURLE_SSL_PEER_CERTIFICATE' => 51,
        'CURLE_SSL_ENGINE_SETFAILED' => 54,
        'CURLE_SSL_ENGINE_NOTFOUND' => 53,
        'CURLE_SSL_CONNECT_ERROR' => 35,
        'CURLE_SSL_CIPHER' => 59,
        'CURLE_SSL_CERTPROBLEM' => 58,
        'CURLE_SSL_CACERT' => 60,
        'CURLE_SHARE_IN_USE' => 57,
        'CURLE_SEND_ERROR' => 55,
        'CURLE_RECV_ERROR' => 56,
        'CURLE_READ_ERROR' => 26,
        'CURLE_PARTIAL_FILE' => 18,
        'CURLE_OUT_OF_MEMORY' => 27,
        'CURLE_OPERATION_TIMEOUTED' => 28,
        'CURLE_OK' => 0,
        'CURLE_OBSOLETE' => 50,
        'CURLE_MALFORMAT_USER' => 24,
        'CURLE_LIBRARY_NOT_FOUND' => 40,
        'CURLE_LDAP_SEARCH_FAILED' => 39,
        'CURLE_LDAP_INVALID_URL' => 62,
        'CURLE_LDAP_CANNOT_BIND' => 38,
        'CURLE_HTTP_RANGE_ERROR' => 33,
        'CURLE_HTTP_POST_ERROR' => 34,
        'CURLE_HTTP_PORT_FAILED' => 45,
        'CURLE_HTTP_NOT_FOUND' => 22,
        'CURLE_GOT_NOTHING' => 52,
        'CURLE_FUNCTION_NOT_FOUND' => 41,
        'CURLE_FTP_WRITE_ERROR' => 20,
        'CURLE_FTP_WEIRD_USER_REPLY' => 12,
        'CURLE_FTP_WEIRD_SERVER_REPLY' => 8,
        'CURLE_FTP_WEIRD_PASV_REPLY' => 13,
        'CURLE_FTP_WEIRD_PASS_REPLY' => 11,
        'CURLE_FTP_WEIRD_227_FORMAT' => 14,
        'CURLE_FTP_USER_PASSWORD_INCORRECT' => 10,
        'CURLE_FTP_SSL_FAILED' => 64,
        'CURLE_FTP_QUOTE_ERROR' => 21,
        'CURLE_FTP_PORT_FAILED' => 30,
        'CURLE_FTP_COULDNT_USE_REST' => 31,
        'CURLE_FTP_COULDNT_STOR_FILE' => 25,
        'CURLE_FTP_COULDNT_SET_BINARY' => 17,
        'CURLE_FTP_COULDNT_SET_ASCII' => 29,
        'CURLE_FTP_COULDNT_RETR_FILE' => 19,
        'CURLE_FTP_COULDNT_GET_SIZE' => 32,
        'CURLE_FTP_CANT_RECONNECT' => 16,
        'CURLE_FTP_CANT_GET_HOST' => 15,
        'CURLE_FTP_BAD_DOWNLOAD_RESUME' => 36,
        'CURLE_FTP_ACCESS_DENIED' => 9,
        'CURLE_FILE_COULDNT_READ_FILE' => 37,
        'CURLE_FILESIZE_EXCEEDED' => 63,
        'CURLE_FAILED_INIT' => 2,
        'CURLE_COULDNT_RESOLVE_PROXY' => 5,
        'CURLE_COULDNT_RESOLVE_HOST' => 6,
        'CURLE_COULDNT_CONNECT' => 7,
        'CURLE_BAD_PASSWORD_ENTERED' => 46,
        'CURLE_BAD_FUNCTION_ARGUMENT' => 43,
        'CURLE_BAD_CONTENT_ENCODING' => 61,
        'CURLE_BAD_CALLING_ORDER' => 44,
        'CURLE_ABORTED_BY_CALLBACK' => 42,
        'CURLCLOSEPOLICY_SLOWEST' => 4,
        'CURLCLOSEPOLICY_OLDEST' => 1,
        'CURLCLOSEPOLICY_LEAST_TRAFFIC' => 3,
        'CURLCLOSEPOLICY_LEAST_RECENTLY_USED' => 2,
        'CURLCLOSEPOLICY_CALLBACK' => 5,
        'CURLAUTH_NTLM_WB' => 32,
        'CURLAUTH_NTLM' => 8,
        'CURLAUTH_NEGOTIATE' => 4,
        'CURLAUTH_GSSNEGOTIATE' => 4,
        'CURLAUTH_DIGEST' => 2,
        'CURLAUTH_BASIC' => 1,
        'CURLAUTH_ANYSAFE' => -2,
        'CURLAUTH_ANY' => -1,
    ];

    private $method;
    private $baseUrl;
    private $url;
    private $parameters;
    public $start_time;

    /**
     * Client constructor.
     *      *    $client = new Client([
     *         'base_uri'        => 'http://www.test.com/',
     *         'timeout'         => 0,
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
        $this->start_time = microtime();

        if (!extension_loaded('curl')) {
            throw new \ErrorException('curl library is not loaded');
        }

        if($config){
            foreach ($config as $key => $value){
                switch (strtolower($key)){
                    case 'baseurl':
                        $this->baseUrl = rtrim($value,'/').'/';
                        unset($config[$key]);
                        break;

                    case 'method':
                        $this->method = $value;
                        unset($config[$key]);
                        break;

                    case 'timeout':
                        $this->config['CURLOPT_CONNECTTIMEOUT'] = intval($value);  //在尝试连接时等待的秒数。设置为0，则无限等待。
                        unset($config[$key]);
                        break;

                    case 'proxy':
                        if(is_array($value) && !empty($value)){
                            $this->config['CURLOPT_PROXY'] = $value[0];
                            if(isset($value[1])) $this->config['CURLOPT_PROXYUSERPWD'] = $value[1];
                        }else{
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
     * @param string $parameters
     * @return CurlResponse
     */
    public function post($url, $parameters = '')
    {
        $this->request('POST', $url, $parameters);

        return $this->exec();
    }


    public function request($method = '', $url = '', $parameters = '')
    {
        //请求方式
        $this->method = $method;
        $this->url = $this->baseUrl . $url;
        $this->parameters = $parameters;

        return $this->exec();
    }

    /**
     * @return CurlResponse
     * @throws CurlException
     */
    public function exec()
    {

        //curl 请求的句柄
        $curlObj = curl_init();

        $this->_set_method();

        if(empty($this->url)){
            throw new CurlException('请设置请求的url');
        }

        //请求的网址
        $this->config['CURLOPT_URL'] = $this->url;
        $this->config['CURLOPT_RETURNTRANSFER'] = true; //TRUE 将curl_exec()获取的信息以字符串返回，而不是直接输出。

        foreach ($this->config as $key => $row) {
            curl_setopt($curlObj, $this->curlOptions[$key], $row);
        }

        return new CurlResponse($this,$curlObj);

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

                    $url = (stripos($this->_url, '?') !== false) ? '&' : '?';

                    if (is_array($this->config['parameters'])) {  //参数是数组
                        $url .= http_build_query($this->_parameters, '', '&');
                    } else { //参数是字符串
                        $url .= $this->config['parameters'];
                    }

                    $this->url = $url;
                    unset($url);
                }

                $this->config['CURLOPT_HTTPGET'] = true;  //TRUE 时会设置 HTTP 的 method 为 GET

                break;

            case 'POST':

                if (!empty($this->parameters) && is_array($this->parameters) && !$this->_is_upload) { //参数是数组
                    $data = http_build_query($this->config['parameters']); //为了更好的兼容性
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
     * @param $time
     * @return $this
     */
    public function setParameters($data){
        $this->parameters = $data;
        return $this;
    }

    /**
     * 获取请求的url地址
     * @return string
     */
    public function getParameters(){
        return $this->parameters;
    }

    /**
     * @param $time
     * @return $this
     */
    public function setTimeout($time){
        $this->config['CURLOPT_CONNECTTIMEOUT'] = intval($time);
        return $this;
    }

    /**
     * 获取请求的url地址
     * @return string
     */
    public function getTimeout(){
        return $this->config['CURLOPT_CONNECTTIMEOUT'] ?? 0;
    }

    /**
     * @param $url
     * @return $this
     */
    public function setUrl($url){
        $this->url = $url;
        return $this;
    }

    /**
     * 获取请求的url地址
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param $method
     * @return $this
     */
    public function setMethod($method){
        $this->method = $method;
        return $this;
    }

    /**
     * 获取请求方式
     */
    public function getMethod()
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
        if (stripos('get', $name) === 0) {
            $name = ltrim($name, 'get');
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
        if (stripos('set', $name) === 0) {
            $name = ltrim($name, 'set');
        }

        $name = strtoupper($name);
        if (array_key_exists($name, $this->curlOptions)) {
            $this->config[$name] = $arguments;
        } else {
            throw new \RuntimeException('curl的参数: ' . $name . '不存在的,请检查设置');
        }
    }

}