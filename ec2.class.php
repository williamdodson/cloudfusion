<?php
/**
 * File: Amazon EC2
 * 	Amazon Elastic Compute Cloud (http://aws.amazon.com/ec2)
 *
 * Version:
 * 	2008.08.20
 * 
 * Copyright:
 * 	2006-2008 LifeNexus Digital, Inc., and contributors.
 * 
 * License:
 * 	Simplified BSD License - http://opensource.org/licenses/bsd-license.php
 * 
 * See Also:
 * 	Tarzan - http://tarzan-aws.com
 * 	Amazon EC2 - http://aws.amazon.com/ec2
 */


/*%******************************************************************************************%*/
// CONSTANTS

/**
 * Constant: EC2_DEFAULT_URL
 * 	Specify the default queue URL.
 */
define('EC2_DEFAULT_URL', 'ec2.amazonaws.com');


/*%******************************************************************************************%*/
// MAIN CLASS

/**
 * Class: AmazonEC2
 * 	Container for all Amazon EC2-related methods. Inherits additional methods from TarzanCore.
 * 
 * Extends:
 * 	TarzanCore
 * 
 * Example Usage:
 * (start code)
 * require_once('tarzan.class.php');
 * 
 * // Instantiate a new AmazonEC2 object using the settings from the config.inc.php file.
 * $s3 = new AmazonEC2();
 * 
 * // Instantiate a new AmazonEC2 object using these specific settings.
 * $s3 = new AmazonEC2($key, $secret_key);
 * (end)
 */
class AmazonEC2 extends TarzanCore
{
	/*%******************************************************************************************%*/
	// CONSTRUCTOR

	/**
	 * Method: __construct()
	 * 	The constructor
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	key - _string_ (Optional) Your Amazon API Key. If blank, it will look for the <AWS_KEY> constant.
	 * 	secret_key - _string_ (Optional) Your Amazon API Secret Key. If blank, it will look for the <AWS_SECRET_KEY> constant.
	 * 	account_id - _string_ (Optional) Your Amazon Account ID, without hyphens. If blank, it will look for the <AWS_ACCOUNT_ID> constant.
	 * 
	 * Returns:
	 * 	_boolean_ false if no valid values are set, otherwise true.
	 */
	public function __construct($key = null, $secret_key = null, $account_id = null)
	{
		$this->api_version = '2008-02-01';
		parent::__construct($key, $secret_key, $account_id);
	}


	/*%******************************************************************************************%*/
	// AVAILABILITY ZONES

	/**
	 * Method: describe_availability_zones()
	 * 	Describes availability zones that are currently available to the account and their states.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	opt - _array_ (Optional) Associative array of parameters which can have the following keys:
	 * 
	 * Keys for the $opt parameter:
	 * 	ZoneName.n - _string_ (Optional) Name of an availability zone.
	 * 
	 * Returns:
	 * 	<TarzanHTTPResponse> object
 	 * 
	 * See Also:
	 * 	AWS Method - http://docs.amazonwebservices.com/AWSEC2/2008-02-01/DeveloperGuide/ApiReference-Query-DescribeAvailabilityZones.html
	 */
	public function describe_availability_zones($opt = null)
	{
		return $this->authenticate('DescribeAvailabilityZones', $opt, EC2_DEFAULT_URL);
	}


	/*%******************************************************************************************%*/
	// ELASTIC IP ADDRESSES

	// Not yet implemented. New as of 2008-02-01.
	public function allocate_address() {}

	// Not yet implemented. New as of 2008-02-01.
	public function associate_address() {}

	// Not yet implemented. New as of 2008-02-01.
	public function describe_addresses() {}

	// Not yet implemented. New as of 2008-02-01.
	public function disassociate_address() {}

	// Not yet implemented. New as of 2008-02-01.
	public function release_address() {}


	/*%******************************************************************************************%*/
	// EBS SNAPSHOTS TO S3

	// Not yet implemented. New as of 2008-05-05.
	public function create_snapshot() {}

	// Not yet implemented. New as of 2008-05-05.
	public function describe_snapshots() {}

	// Not yet implemented. New as of 2008-05-05.
	public function delete_snapshot() {}


	/*%******************************************************************************************%*/
	// EBS VOLUMES

	// Not yet implemented. New as of 2008-05-05.
	public function create_volume() {}

	// Not yet implemented. New as of 2008-05-05.
	public function describe_volumes() {}

	// Not yet implemented. New as of 2008-05-05.
	public function attach_volume() {}

	// Not yet implemented. New as of 2008-05-05.
	public function detach_volume() {}

	// Not yet implemented. New as of 2008-05-05.
	public function delete_volume() {}


	/*%******************************************************************************************%*/
	// MISCELLANEOUS

	// Not yet implemented. New as of 2008-02-01.
	public function get_console_output() {}

	// Not yet implemented. New as of 2008-02-01.
	public function reboot_instances() {}


	/*%******************************************************************************************%*/
	// IMAGES

	/**
	 * Method: deregister_image()
	 * 	De-registers an AMI. Once de-registered, instances of the AMI may no longer be launched.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	image_id - _string_ (Required) Unique ID of a machine image, returned by a call to <register_image()> or <describe_images()>.
	 * 
	 * Returns:
	 * 	<TarzanHTTPResponse> object
 	 * 
	 * See Also:
	 * 	AWS Method - http://docs.amazonwebservices.com/AWSEC2/2007-03-01/DeveloperGuide/ApiReference-Query-DeregisterImage.html
	 * 	Related - <describe_images()>, <register_image()>
	 */
	public function deregister_image($image_id)
	{
		if (!$opt)
		{
			$opt = array();
		}

		if ($image_id)
		{
			$opt['ImageId'] = $image_id;
		}

		return $this->authenticate('DeregisterImage', $opt, EC2_DEFAULT_URL);
	}

	/**
	 * Method: describe_images()
	 * 	Returns information about AMIs available for use by the user. This includes both public AMIs (those available for any user to launch) and private AMIs (those owned by the user making the request and those owned by other users that the user making the request has explicit launch permissions for).
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	opt - _array_ (Optional) Associative array of parameters which can have the following keys:
	 * 
	 * Keys for the $opt parameter:
 	 * 	ExecutableBy.n - _string_ (Optional) Describe AMIs that the specified users have launch permissions for. Accepts Amazon account ID, 'self', or 'all' for public AMIs.
	 * 	ImageId.n - _string_ (Optional) A list of image descriptions.
	 * 	Owner.n - _string_ (Optional) Owners of AMIs to describe.
	 * 
	 * Returns:
	 * 	<TarzanHTTPResponse> object
 	 * 
	 * See Also:
	 * 	AWS Method - http://docs.amazonwebservices.com/AWSEC2/2007-03-01/DeveloperGuide/ApiReference-Query-DescribeImages.html
	 * 	Related - <deregister_image()>, <register_image()>
	 */
	public function describe_images($opt = null)
	{
		if (!$opt)
		{
			$opt = array();
		}

		return $this->authenticate('DescribeImages', $opt, EC2_DEFAULT_URL);
	}

	/**
	 * Method: register_image()
	 * 	Registers an AMI with Amazon EC2. Images must be registered before they can be launched via <run_instances()>.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	image_location - _string_ (Required) Full path to your AMI manifest in Amazon S3 storage (i.e. mybucket/myimage.manifest.xml).
	 * 
	 * Returns:
	 * 	<TarzanHTTPResponse> object
 	 * 
	 * See Also:
	 * 	AWS Method - http://docs.amazonwebservices.com/AWSEC2/2007-03-01/DeveloperGuide/ApiReference-Query-RegisterImage.html
	 * 	Related - <deregister_image()>, <describe_images()>
	 */
	public function register_image($image_location)
	{
		if (!$opt)
		{
			$opt = array();
		}

		if ($image_location)
		{
			$opt['ImageLocation'] = $image_location;
		}

		return $this->authenticate('RegisterImage', $opt, EC2_DEFAULT_URL);
	}


	/*%******************************************************************************************%*/
	// IMAGE ATTRIBUTES

	/**
	 * Method: describe_image_attribute()
	 * 	Returns information about an attribute of an AMI. Only one attribute may be specified per call.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	image_id - _string_ (Required) Unique ID of a machine image, returned by a call to <register_image()> or <describe_images()>.
	 * 
	 * Returns:
	 * 	<TarzanHTTPResponse> object
 	 * 
	 * See Also:
	 * 	AWS Method - http://docs.amazonwebservices.com/AWSEC2/2007-03-01/DeveloperGuide/ApiReference-Query-DescribeImageAttribute.html
	 * 	Related - <modify_image_attribute()>, <reset_image_attribute()>
	 */
	public function describe_image_attribute($image_id)
	{
		if (!$opt)
		{
			$opt = array();
		}

		if ($image_id)
		{
			$opt['ImageId'] = $image_id;
		}

		// This is the only supported value in the EC2 2007-03-01 release.
		$opt['Attribute'] = 'launchPermission';

		return $this->authenticate('DescribeImageAttribute', $opt, EC2_DEFAULT_URL);
	}

	/**
	 * Method: modify_image_attribute()
	 * 	Modifies an attribute of an AMI.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	image_id - _string_ (Required) AMI ID to modify an attribute on.
	 * 	attribute - _string_ (Required) Specifies the attribute to modify. Supports 'launchPermission' and 'productCodes'.
	 * 	opt - _array_ (Optional) Associative array of parameters which can have the following keys:
	 * 
	 * Keys for the $opt parameter:
 	 * 	OperationType - _string_ (Required for 'launchPermission' Attribute) Specifies the operation to perform on the attribute. Supports 'add' and 'remove'.
 	 * 	UserId.n - _string_ (Required for 'launchPermission' Attribute) User IDs to add to or remove from the 'launchPermission' attribute.
 	 * 	UserGroup.n - _string_ (Required for 'launchPermission' Attribute) User groups to add to or remove from the 'launchPermission' attribute. Currently, only the 'all' group is available, specifiying all Amazon EC2 users.
 	 * 	ProductCode.n - _string_ (Required for 'productCodes' Attribute) Attaches product codes to the AMI. Currently only one product code may be associated with an AMI. Once set, the product code can not be changed or reset.
	 * 
	 * Returns:
	 * 	<TarzanHTTPResponse> object
 	 * 
	 * See Also:
	 * 	AWS Method - http://docs.amazonwebservices.com/AWSEC2/2007-03-01/DeveloperGuide/ApiReference-Query-ModifyImageAttribute.html
	 * 	Related - <describe_image_attribute()>, <reset_image_attribute()>
	 */
	public function modify_image_attribute($image_id, $attribute, $opt = null)
	{
		if (!$opt)
		{
			$opt = array();
		}

		return $this->authenticate('ModifyImageAttribute', $opt, EC2_DEFAULT_URL);
	}

	/**
	 * Method: reset_image_attribute()
	 * 	Resets an attribute of an AMI to its default value.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	image_id - _string_ (Required) Unique ID of a machine image, returned by a call to <register_image()> or <describe_images()>.
	 * 
	 * Returns:
	 * 	<TarzanHTTPResponse> object
 	 * 
	 * See Also:
	 * 	AWS Method - http://docs.amazonwebservices.com/AWSEC2/2007-03-01/DeveloperGuide/ApiReference-Query-ResetImageAttribute.html
	 * 	Related - <describe_image_attribute()>, <modify_image_attribute()>
	 */
	public function reset_image_attribute($image_id)
	{
		if (!$opt)
		{
			$opt = array();
		}

		if ($image_id)
		{
			$opt['ImageId'] = $image_id;
		}

		// This is the only supported value in the EC2 2007-03-01 release.
		$opt['Attribute'] = 'launchPermission';

		return $this->authenticate('ResetImageAttribute', $opt, EC2_DEFAULT_URL);
	}


	/*%******************************************************************************************%*/
	// INSTANCES

	/**
	 * Method: confirm_product_instance()
	 * 	Returns true if the given product code is attached to the instance with the given instance ID. The operation returns false if the product code is not attached to the instance.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	product_code - _string_ (Required) The product code to confirm is attached to the instance.
	 * 	instance_id - _string_ (Required) The instance to confirm.
	 * 
	 * Returns:
	 * 	<TarzanHTTPResponse> object
 	 * 
	 * See Also:
	 * 	AWS Method - http://docs.amazonwebservices.com/AWSEC2/2007-03-01/DeveloperGuide/ApiReference-Query-ConfirmProductInstance.html
	 * 	Related - <describe_instances()>, <run_instances()>, <terminate_instances()>
	 */
	public function confirm_product_instance($product_code, $instance_id)
	{
		if (!$opt)
		{
			$opt = array();
		}

		if ($product_code)
		{
			$opt['ProductCode'] = $product_code;
		}

		if ($instance_id)
		{
			$opt['InstanceId'] = $instance_id;
		}

		return $this->authenticate('ConfirmProductInstance', $opt, EC2_DEFAULT_URL);
	}

	/**
	 * Method: describe_instances()
	 * 	Returns information about instances owned by the user making the request.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	opt - _array_ (Optional) Associative array of parameters which can have the following keys:
	 * 
	 * Keys for the $opt parameter:
	 * 	InstanceId.n - _string_ (Required) Set of instances IDs to get the status of.
	 * 
	 * Returns:
	 * 	<TarzanHTTPResponse> object
 	 * 
	 * See Also:
	 * 	AWS Method - http://docs.amazonwebservices.com/AWSEC2/2007-03-01/DeveloperGuide/ApiReference-Query-DescribeInstances.html
	 * 	Related - <confirm_product_instance()>, <run_instances()>, <terminate_instances()>
	 */
	public function describe_instances($opt = null)
	{
		if (!$opt)
		{
			$opt = array();
		}

		return $this->authenticate('DescribeInstances', $opt, EC2_DEFAULT_URL);
	}

	/**
	 * Method: run_instances()
	 * 	Launches a specified number of instances. A call to <run_instances()> is guaranteed to start no fewer than the requested minimum. If there is insufficient capacity available then no instances will be started. Amazon EC2 will make a best effort attempt to satisfy the requested maximum values.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	image_id - _string_ (Required) ID of the AMI to launch instances based on.
	 * 	min_count - _integer_ (Required) Minimum number of instances to launch.
	 * 	max_count - _integer_ (Required) Maximum number of instances to launch.
	 * 	opt - _array_ (Optional) Associative array of parameters which can have the following keys:
	 * 
	 * Keys for the $opt parameter:
	 * 	AddressingType - _string_ (Optional) The addressing scheme to launch the instance with. The addressing type can be direct or public. In the direct scheme the instance has one IP address that is not NAT'd. For the public scheme the instance has a NAT'd IP address. See the section called "Instance Addressing" for more information on instance addressing.
	 * 	KeyName - _string_ (Optional) Name of the keypair to launch instances with.
	 * 	SecurityGroup.n - _string_ (Optional) Names of the security groups to associate the instances with.
	 * 	UserData - _string_ (Optional) The user data available to the launched instances. This should be base64-encoded. See the UserDataType data type for encoding details.
	 * 
	 * Returns:
	 * 	<TarzanHTTPResponse> object
 	 * 
	 * See Also:
	 * 	AWS Method - http://docs.amazonwebservices.com/AWSEC2/2007-03-01/DeveloperGuide/ApiReference-Query-RunInstances.html
	 * 	Related - <confirm_product_instance()>, <describe_instances()>, <terminate_instances()>
	 */
	public function run_instances($image_id, $min_count, $max_count, $opt = null)
	{
		if (!$opt)
		{
			$opt = array();
		}

		if ($image_id)
		{
			$opt['ImageId'] = $image_id;
		}

		if ($min_count)
		{
			$opt['MinCount'] = $min_count;
		}

		if ($max_count)
		{
			$opt['MaxCount'] = $max_count;
		}

		return $this->authenticate('RunInstances', $opt, EC2_DEFAULT_URL);
	}

	/**
	 * Method: terminate_instances()
	 * 	Shuts down one or more instances. This operation is idempotent and terminating an instance that is in the process of shutting down (or already terminated) will succeed.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	opt - _array_ (Optional) Associative array of parameters which can have the following keys:
	 * 
	 * Keys for the $opt parameter:
	 * 	InstanceId.1 - _string_ (Required) One instance ID returned from previous calls to <run_instances()>.
	 * 	InstanceId.n - _string_ (Optional) More than one instance IDs returned from previous calls to <run_instances()>.
	 * 
	 * Returns:
	 * 	<TarzanHTTPResponse> object
 	 * 
	 * See Also:
	 * 	AWS Method - http://docs.amazonwebservices.com/AWSEC2/2007-03-01/DeveloperGuide/ApiReference-Query-TerminateInstances.html
	 * 	Related - <confirm_product_instance()>, <describe_instances()>, <run_instances()>
	 */
	public function terminate_instances($opt = null)
	{
		if (!$opt)
		{
			$opt = array();
		}

		return $this->authenticate('TerminateInstances', $opt, EC2_DEFAULT_URL);
	}


	/*%******************************************************************************************%*/
	// KEYPAIRS

	/**
	 * Method: create_key_pair()
	 * 	Creates a new 2048 bit RSA keypair and returns a unique ID that can be used to reference this keypair when launching new instances.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	key_name - _string_ (Required) Unique name for this key.
	 * 
	 * Returns:
	 * 	<TarzanHTTPResponse> object
 	 * 
	 * See Also:
	 * 	AWS Method - http://docs.amazonwebservices.com/AWSEC2/2007-03-01/DeveloperGuide/ApiReference-Query-CreateKeyPair.html
	 * 	Related - <delete_key_pair()>, <describe_key_pairs()>
	 */
	public function create_key_pair($key_name)
	{
		if (!$opt)
		{
			$opt = array();
		}

		if ($key_name)
		{
			$opt['KeyName'] = $key_name;
		}

		return $this->authenticate('CreateKeyPair', $opt, EC2_DEFAULT_URL);
	}

	/**
	 * Method: delete_key_pair()
	 * 	Deletes a keypair.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	key_name - _string_ (Required) Unique name for this key.
	 * 
	 * Returns:
	 * 	<TarzanHTTPResponse> object
 	 * 
	 * See Also:
	 * 	AWS Method - http://docs.amazonwebservices.com/AWSEC2/2007-03-01/DeveloperGuide/ApiReference-Query-DeleteKeyPair.html
	 * 	Related - <create_key_pair()>, <describe_key_pairs()>
	 */
	public function delete_key_pair($key_name)
	{
		if (!$opt)
		{
			$opt = array();
		}

		if ($key_name)
		{
			$opt['KeyName'] = $key_name;
		}

		return $this->authenticate('DeleteKeyPair', $opt, EC2_DEFAULT_URL);
	}

	/**
	 * Method: describe_key_pairs()
	 * 	Returns information about keypairs available for use by the user making the request. Selected keypairs may be specified or the list may be left empty if information for all registered keypairs is required.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	opt - _array_ (Optional) Associative array of parameters which can have the following keys:
	 * 
	 * Keys for the $opt parameter:
	 * 	KeyName.n - _string_ (Optional) One or more keypair IDs to describe.
	 * 
	 * Returns:
	 * 	<TarzanHTTPResponse> object
 	 * 
	 * See Also:
	 * 	AWS Method - http://docs.amazonwebservices.com/AWSEC2/2007-03-01/DeveloperGuide/ApiReference-Query-DescribeKeyPairs.html
	 * 	Related - <create_key_pair()>, <delete_key_pair()>
	 */
	public function describe_key_pairs($opt = null)
	{
		if (!$opt)
		{
			$opt = array();
		}

		return $this->authenticate('DescribeKeyPairs', $opt, EC2_DEFAULT_URL);
	}


	/*%******************************************************************************************%*/
	// SECURITY GROUPS

	/**
	 * Method: authorize_security_group_ingress()
	 * 	Adds permissions to a security group.
	 * 
	 * 	Permissions are specified in terms of the IP protocol (TCP, UDP or ICMP), the source of the request (by IP range or an Amazon EC2 user-group pair), source and destination port ranges (for TCP and UDP), and ICMP codes and types (for ICMP). When authorizing ICMP, -1 may be used as a wildcard in the type and code fields.
	 * 
	 * 	Permission changes are propagated to instances within the security group being modified as quickly as possible. However, a small delay is likely, depending on the number of instances that are members of the indicated group.
	 * 
	 * 	When authorizing a user/group pair permission, group_name, SourceSecurityGroupName and SourceSecurityGroupOwnerId must be specified. When authorizing a CIDR IP permission, GroupName, IpProtocol, FromPort, ToPort and CidrIp must be specified. Mixing these two types of parameters is not allowed.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	group_name - _string_ (Required) Name of the security group to modify.
	 * 	opt - _array_ (Optional) Associative array of parameters which can have the following keys:
	 * 
	 * Keys for the $opt parameter:
	 * 	CidrIp - _string_ (Required when authorizing CIDR IP permission) CIDR IP range to authorize access to when operating on a CIDR IP.
	 * 	FromPort - _integer_ (Required when authorizing CIDR IP permission) Bottom of port range to authorize access to when operating on a CIDR IP. This contains the ICMP type if ICMP is being authorized.
	 * 	ToPort - _integer_ (Required when authorizing CIDR IP permission) Top of port range to authorize access to when operating on a CIDR IP. This contains the ICMP code if ICMP is being authorized.
	 * 	IpProtocol - _string_ (Required when authorizing CIDR IP permission) IP protocol to authorize access to when operating on a CIDR IP. Valid values are 'tcp', 'udp' and 'icmp'.
	 * 	SourceSecurityGroupName - _string_ (Required when authorizing user/group pair permission) Name of security group to authorize access to when operating on a user/group pair.
	 * 	SourceSecurityGroupOwnerId - _string_ (Required when authorizing user/group pair permission) Owner of security group to authorize access to when operating on a user/group pair.
	 * 
	 * Returns:
	 * 	<TarzanHTTPResponse> object
 	 * 
	 * See Also:
	 * 	AWS Method - http://docs.amazonwebservices.com/AWSEC2/2007-03-01/DeveloperGuide/ApiReference-Query-AuthorizeSecurityGroupIngress.html
	 * 	Related - <revoke_security_group_ingress()>, <create_security_group()>, <delete_security_group()>, <describe_security_groups()>
	 */
	public function authorize_security_group_ingress($group_name, $opt = null)
	{
		if (!$opt)
		{
			$opt = array();
		}

		if ($group_name)
		{
			$opt['GroupName'] = $group_name;
		}

		return $this->authenticate('AuthorizeSecurityGroupIngress', $opt, EC2_DEFAULT_URL);
	}

	/**
	 * Method: create_security_group()
	 * 	Every instance is launched in a security group. If none is specified as part of the launch request then instances are launched in the default security group. Instances within the same security group have unrestricted network access to one another. Instances will reject network access attempts from other instances in a different security group. As the owner of instances you may grant or revoke specific permissions using the <authorize_security_group_ingress()> and <revoke_security_group_ingress()> operations.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	group_name - _string_ (Required) Name for the new security group.
	 * 	group_description - _string_ (Required) Description of the new security group.
	 * 
	 * Returns:
	 * 	<TarzanHTTPResponse> object
 	 * 
	 * See Also:
	 * 	AWS Method - http://docs.amazonwebservices.com/AWSEC2/2007-03-01/DeveloperGuide/ApiReference-Query-CreateSecurityGroup.html
	 * 	Related - <authorize_security_group_ingress()>, <revoke_security_group_ingress()>, <delete_security_group()>, <describe_security_groups()>
	 */
	public function create_security_group($group_name, $group_description)
	{
		if (!$opt)
		{
			$opt = array();
		}

		if ($group_name)
		{
			$opt['GroupName'] = $group_name;
		}

		if ($group_description)
		{
			$opt['GroupDescription'] = $group_description;
		}

		return $this->authenticate('CreateSecurityGroup', $opt, EC2_DEFAULT_URL);
	}

	/**
	 * Method: delete_security_group()
	 * 	Deletes a security group. If an attempt is made to delete a security group and any instances exist that are members of that group a fault is returned.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	group_name - _string_ (Required) Name for the new security group.
	 * 
	 * Returns:
	 * 	<TarzanHTTPResponse> object
 	 * 
	 * See Also:
	 * 	AWS Method - http://docs.amazonwebservices.com/AWSEC2/2007-03-01/DeveloperGuide/ApiReference-Query-DeleteSecurityGroup.html
	 * 	Related - <authorize_security_group_ingress()>, <revoke_security_group_ingress()>, <create_security_group()>, <describe_security_groups()>
	 */
	public function delete_security_group($group_name)
	{
		if (!$opt)
		{
			$opt = array();
		}

		if ($group_name)
		{
			$opt['GroupName'] = $group_name;
		}

		return $this->authenticate('DeleteSecurityGroup', $opt, EC2_DEFAULT_URL);
	}

	/**
	 * Method: describe_security_groups()
	 * 	Returns information about security groups owned by the user making the request. An optional list of security group names may be provided to request information for those security groups only. If no security group names are provided, information of all security groups will be returned. If a group is specified that does not exist a fault is returned.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	opt - _array_ (Optional) Associative array of parameters which can have the following keys:
	 * 
	 * Keys for the $opt parameter:
	 * 	GroupName.n - _string_ (Optional) List of security groups to describe.
	 * 
	 * Returns:
	 * 	<TarzanHTTPResponse> object
 	 * 
	 * See Also:
	 * 	AWS Method - http://docs.amazonwebservices.com/AWSEC2/2007-03-01/DeveloperGuide/ApiReference-Query-DescribeSecurityGroups.html
	 * 	Related - <authorize_security_group_ingress()>, <revoke_security_group_ingress()>, <create_security_group()>, <delete_security_group()>
	 */
	public function describe_security_groups($opt = null)
	{
		if (!$opt)
		{
			$opt = array();
		}

		return $this->authenticate('DescribeSecurityGroups', $opt, EC2_DEFAULT_URL);
	}

	/**
	 * Method: revoke_security_group_ingress()
	 * 	Revokes existing permissions that were previously granted to a security group. The permissions to revoke must be specified using the same values originally used to grant the permission.
	 * 
	 * 	Permissions are specified in terms of the IP protocol (TCP, UDP or ICMP), the source of the request (by IP range or an Amazon EC2 user-group pair), source and destination port ranges (for TCP and UDP), and ICMP codes and types (for ICMP). When authorizing ICMP, -1 may be used as a wildcard in the type and code fields.
	 * 
	 * 	Permission changes are propagated to instances within the security group being modified as quickly as possible. However, a small delay is likely, depending on the number of instances that are members of the indicated group.
	 * 
	 * 	When revoking a user/group pair permission, group_name, SourceSecurityGroupName and SourceSecurityGroupOwnerId must be specified. When authorizing a CIDR IP permission, GroupName, IpProtocol, FromPort, ToPort and CidrIp must be specified. Mixing these two types of parameters is not allowed.
	 * 
	 * Access:
	 * 	public
	 * 
	 * Parameters:
	 * 	group_name - _string_ (Required) Name of the security group to modify.
	 * 	opt - _array_ (Optional) Associative array of parameters which can have the following keys:
	 * 
	 * Keys for the $opt parameter:
	 * 	CidrIp - _string_ (Required when revoking CIDR IP permission) CIDR IP range to authorize access to when operating on a CIDR IP.
	 * 	FromPort - _integer_ (Required when revoking CIDR IP permission) Bottom of port range to authorize access to when operating on a CIDR IP. This contains the ICMP type if ICMP is being authorized.
	 * 	ToPort - _integer_ (Required when revoking CIDR IP permission) Top of port range to authorize access to when operating on a CIDR IP. This contains the ICMP code if ICMP is being authorized.
	 * 	IpProtocol - _string_ (Required when revoking CIDR IP permission) IP protocol to authorize access to when operating on a CIDR IP. Valid values are 'tcp', 'udp' and 'icmp'.
	 * 	SourceSecurityGroupName - _string_ (Required when revoking user/group pair permission) Name of security group to authorize access to when operating on a user/group pair.
	 * 	SourceSecurityGroupOwnerId - _string_ (Required when revoking user/group pair permission) Owner of security group to authorize access to when operating on a user/group pair.
	 * 
	 * Returns:
	 * 	<TarzanHTTPResponse> object
 	 * 
	 * See Also:
	 * 	AWS Method - http://docs.amazonwebservices.com/AWSEC2/2007-03-01/DeveloperGuide/ApiReference-Query-RevokeSecurityGroupIngress.html
	 * 	Related - <authorize_security_group_ingress()>, <create_security_group()>, <delete_security_group()>, <describe_security_groups()>
	 */
	public function revoke_security_group_ingress($group_name, $opt = null)
	{
		if (!$opt)
		{
			$opt = array();
		}

		if ($group_name)
		{
			$opt['GroupName'] = $group_name;
		}

		return $this->authenticate('RevokeSecurityGroupIngress', $opt, EC2_DEFAULT_URL);
	}
}
?>