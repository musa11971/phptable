# phptable
phptable allows you to easily turn your PHP data into HTML tables just by using simple functions, instead of having to work with loops and annoying, repetitive code.

### Features
* Turn your data into a table using simple to use functions.
* Add static columns to your table and embed data.
* PDO fetch data format compatible.
* Create CRUD tables within minutes.

### Example code

	$data = [
		new Employee('Frank', 'Sales', 75000),
		new Employee('John', 'IT', 80825),
		new Employee('Susan', 'Marketing', 82000),
		new Employee('Jane', 'Legal', 105000)
	];

	$table = new PHPTable('employees');
	$table->setHeadings([
		'Name',
		'Department',
		'Salary'
	]);

	$table->bindData($data);

	echo $table->html();
<table><thead><tr><th>Name</th><th>Department</th><th>Salary</th></tr></thead><tbody><tr><td>Frank</td><td>Sales</td><td>75000</td></tr><tr><td>John</td><td>IT</td><td>80825</td></tr><tr><td>Susan</td><td>Marketing</td><td>82000</td></tr><tr><td>Jane</td><td>Legal</td><td>105000</td></tr></tbody></table>  
  
  
  ### Getting started
  Please head over to the [wiki](https://github.com/musa11971/phptable/wiki) to learn how to use phptable from a to z.
