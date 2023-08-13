<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;
use DB;
use Illuminate\Support\Facades\Artisan;

class ItemCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'item:run';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Create and sort items';

    /**
     * Execute the validation check.
     *
     * @return void
     */
    protected function validateCheck($name,$quantity,$price)
    {
        $errors = []; 
        //Name validations start
        if (! $name) {
            $errors[] = 'Name is required.';
        }

        if (strlen($name) > 14) {
            $errors[] = 'Name must be less than 14 charectors.';
        }
       
        if (isset($name) ) {
            if(preg_match('/^[a-z0-9\s]*$/i', $name) == 0){
                $errors[] = 'Invalid Name.';
            }
            $count = DB::table('items')->where(DB::raw('BINARY `name`'), $name)->count();
            if($count>0){
                $errors[] = 'Name is already exist.';
            }
        }
        //Name validations end

        //Quantity validations start
        if (! $quantity) {
            $errors[] = 'Quantity is required.';
        }

        $quantity = intval($quantity);
        if (!is_int($quantity) || $quantity <= 0) {
            $errors[] = 'Quantity must integer or greater than 0.';
        }
        //Quantity validations end

        //Price validations start
        if (! $price) {
            $errors[] = 'Price is required.';
        }      

        $price = floatval($price);
        if (preg_match('/\.\d{3,}/', $price) || $price <= 0 ) {
            $errors[] = 'Price must have min 2 decimal number.';
        }
        //Price validations end
        
        if(!empty($errors)){
            collect($errors)
                ->each(fn ($error) => $this->error($error));
            exit;
        }
    }

    /**
     * Execute the validation check.
     *
     * @return void
     */
    protected function performAdd()
    {
        $name = $this->ask('What is item name?');
        $quantity = $this->ask('What is item quantity?');
        $price = $this->ask('What is item price?');
        $action = 'add';

        $this->validateCheck($name,$quantity,$price,$action);

        DB::table('items')->insert(
            [
                'name' => $name,
                'quantity' => $quantity,
                'price' => $price,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')                
            ]
        );
        $this->info('Item added successfuly.');
        $items = DB::table('items')->get();
        $this->table(
            ['ID', 'Name', 'Quantity', 'Price', 'Created At', 'Updated At'],
            json_decode(json_encode($items), True)
        );
    }

    /**
     * Execute the shoert items.
     *
     * @return void
     */
    protected function shortItems($shortChoice)
    {
        $start = now();
        $shortQuery = DB::table('items')->select('*');
        switch ($shortChoice) {
            case 'Name':
                $shortQuery->orderBy('name','asc');
                break;
            case 'Quantity':
                $shortQuery->orderBy('quantity','asc')->orderBy('name','asc');
                break;
            case 'Price':
                $shortQuery->orderBy('price','asc')->orderBy('name','asc');
                break;
            case 'Time':
                $shortQuery->orderBy('price','asc')->orderBy('name','asc');
                break;
        }

        $this->info('Item sored by '.$shortChoice.' successfuly.');
        $items = $shortQuery->get();
        $this->table(
            ['ID', 'Name', 'Quantity', 'Price', 'Created At', 'Updated At'],
            json_decode(json_encode($items), True)
        );
        $time = $start->diffInSeconds(now());
        $this->comment("Processed in $time seconds");
    }

    /**
     * Execute the validation check.
     *
     * @return void
     */
    protected function performShort()
    {
        $shortOptions = ['Name','Quantity','Price'];
        $shortChoice = $this->choice('Short by:', $shortOptions);
        
        $this->shortItems($shortChoice);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {   
        $itemsCount = DB::table('items')->count();
        if($itemsCount==0){
            $this->performAdd();
            return;
        }
        $options = ['Add','Short'];
        $choice = $this->choice('Choose an operation:', $options);

        switch ($choice) {
            case 'Add':
                $this->performAdd();
                break;
            case 'Short':
                $this->performShort();
                break;
        }        
    }

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
    
}
