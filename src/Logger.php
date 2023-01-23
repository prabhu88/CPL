<?php
namespace Cpl;
class Logger{
    protected static $log = [];
    public static $print_log = true;
    public static $write_log = false;
    public static $log_dir = __DIR__;
    public static $log_file_name = "log";
    public static $log_file_extension = "log";
    public static $log_file_append = true;
    public static $log_level = 'error';
    public static $default_timer = 'timer';
    private static $log_level_integers = [
        'debug' => 7,
        'info' => 6,
        'warning' => 4,
        'error' => 3
    ];
    private static $log_file_path = '';
    private static $output_streams = [];
    private static $logger_ready = false;

    public static function init(){
        if (!static::$logger_ready){
            if (true === static::$print_log){
                static::$output_streams['stdout'] = STDOUT;
            }
        }
        if (file_exists(static::$log_dir)){
            static::$log_file_path = implode( DIRECTORY_SEPARATOR, [ static::$log_dir, static::$log_file_name ] );
            if ( ! empty( static::$log_file_extension ) ){
                static::$log_file_path .= "." . static::$log_file_extension;
            }
        }
        if ( true === static::$write_log ){
            if ( file_exists( static::$log_dir ) ){
                $mode = static::$log_file_append ? "a" : "w";
                static::$output_streams[ static::$log_file_path ] = fopen ( static::$log_file_path, $mode );
            }
        }
        static::$logger_ready = true;
    }
    
    private static function add( $message, $name = '', $level = 'debug' ){
        if ( static::$log_level_integers[$level] > static::$log_level_integers[static::$log_level] ){
            return;
        }
        $log_entry = [
            'timestamp' => time(),
            'name' => $name,
            'message' => $message,
            'level' => $level,
        ];
        static::$log[] = $log_entry;
        if(!static::$logger_ready ) {
            static::init();
        }
        if(static::$logger_ready && count(static::$output_streams) > 0 ) {
            $output_line = static::format_log_entry( $log_entry ) . PHP_EOL;
            foreach(static::$output_streams as $key => $stream) {
                fputs($stream,$output_line);
            }
        }
        return $log_entry;
    }
    public static function time( string $name = null ){
        if ( $name === null ) {
            $name = static::$default_timer;
        }
        if ( ! isset( static::$time_tracking[ $name ] ) ) {
            static::$time_tracking[ $name ] = microtime( true );
            return static::$time_tracking[ $name ];
        }
        else {
            return false;
        }
    }
    public static function format_log_entry( array $log_entry ) : string {
        $log_line = "";
        if(!empty($log_entry)){
            $log_entry = array_map( function( $v ) { return print_r( $v, true ); }, $log_entry );
            $log_line .= date( 'c', $log_entry['timestamp'] ) . " ";
            $log_line .= "[" . strtoupper( $log_entry['level'] ) . "] : ";
            if(!empty($log_entry['name'])){
                $log_line .= $log_entry['name'] . " :->>-: ";
            }
            $log_line .= $log_entry['message'];
        }
        return $log_line;
    }
}
?>