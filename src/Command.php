/**
 * Command.php file, PHP Command Documentation
 *
 * This file contains Command class
 *
 * THIS SOURCE FILE IS SUBJECT TO THE NEW GLP V2 LICENCE 
 * THAT IS BUNDLED WITH THIS PACKAGE IN THE FILE LICENSE.txt
 *
 * @package    PHP Command
 * @subpackage
 * @author     Gilberto Albino <gilbertoalbino@gmail.com>
 * @version    1.0.2
 * @copyright  The @author, All rights reserved.
 */
 
 /**
  * This class can run Linux commands. See examples for usage.
  */
class Command
{
    /**
     * Static method to effectively run a command.
     * 
     * @param string $command
     * @return string
     */
    public static function run($command)
    {
        $handle = @proc_open($command, array(
            1 => array(
                'pipe',
                'w'
            )
        ), $pipe, NULL, NULL, array(
            'bypass_shell' => true
        ));
        
        if (is_resource($handle)) {
            $output = trim(stream_get_contents($pipe[1]));
            return $output;
        }
        
        return '';
    }

    public static function __callStatic($command, $arguments)
    {
        $command = self::getPath($command);
        $parameters = null;
        
        
        if(isset($arguments[0])) {
            $parameters = $arguments[0];
        }
        
        
        return self::run(
            sprintf('%s %s', $command, $parameters)
        );
    }

    public static function getPath($command)
    {
        switch ($command) {
        	case 'exiftool' :
        	case 'ffmpeg' :
        	    $path = '/usr/local/bin/';
        	    break;
        	case 'convert' :
        	    $path = '/opt/local/bin/';
        	    break;
            default:
                $path = '';
                break;
        }
        return $path . $command;
    }
}
