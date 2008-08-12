<?php
/**
 * AMAZON ELASTIC CLOUD COMPUTING (EC2)
 * http://ec2.amazonaws.com
 *
 * @category Tarzan
 * @package EC2
 * @version 2008.08.11
 * @copyright 2006-2008 Ryan Parman, LifeNexus Digital, Inc., and contributors.
 * @license http://opensource.org/licenses/bsd-license.php Simplified BSD License
 * @link http://tarzan-aws.com Tarzan
 * @link http://ec2.amazonaws.com Amazon EC2
 * @see README
 */


/*%******************************************************************************************%*/
// CONSTANTS

/**
 * Specify the default queue URL.
 */
define('EC2_DEFAULT_URL', 'http://ec2.amazonaws.com/');


/*%******************************************************************************************%*/
// MAIN CLASS

/**
 * Container for all Amazon EC2-related methods.
 */
class AmazonEC2 extends TarzanCore
{
	/*%******************************************************************************************%*/
	// CONSTRUCTOR

	/**
	 * Constructor
	 */
	public function __construct($key = null, $secret_key = null, $account_id = null, $assoc_id = null)
	{
		$this->api_version = '2008-02-01';
		parent::__construct($key, $secret_key, $account_id, $assoc_id);
	}


	/*%******************************************************************************************%*/
	// AVAILABILITY ZONES

	/**
	 * Describe Availability Zones
	 *
	 * Describes availability zones that are currently available to the account and their states. 
	 *
	 * @access public
	 * @param array $opt Associative array of parameters which can have the following keys:
	 * <ul>
	 *   <li>string ZoneName.n - (Optional) Name of an availability zone.</li>
	 * </ul>
	 * @return TarzanHTTPResponse
	 * @see http://docs.amazonwebservices.com/AWSEC2/2008-02-01/DeveloperGuide/ApiReference-Query-DescribeAvailabilityZones.html
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
	// IMAGES

	/**
	 * De-register Image
	 *
	 * De-registers an AMI. Once de-registered, instances of the AMI may no longer be launched.
	 *
	 * @access public
	 * @param string $image_id (Required) Unique ID of a machine image, returned by a call to register_image() or describe_images().
	 * @return TarzanHTTPResponse
	 * @see http://docs.amazonwebservices.com/AWSEC2/2007-03-01/DeveloperGuide/ApiReference-Query-DeregisterImage.html
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
	 * Describe Image
	 *
	 * Returns information about AMIs available for use by the user. This includes both public AMIs (those 
	 * available for any user to launch) and private AMIs (those owned by the user making the request and 
	 * those owned by other users that the user making the request has explicit launch permissions for).
	 *
	 * @access public
	 * @param array $opt Associative array of parameters which can have the following keys:
	 * <ul>
	 *   <li>string ExecutableBy.n - (Optional) Describe AMIs that the specified users have launch permissions for. Accepts Amazon account ID, 'self', or 'all' for public AMIs.</li>
	 *   <li>string ImageId.n - (Optional) A list of image descriptions.</li>
	 *   <li>string Owner.n - (Optional) Owners of AMIs to describe.</li>
	 * </ul>
	 * @return TarzanHTTPResponse
	 * @see http://docs.amazonwebservices.com/AWSEC2/2007-03-01/DeveloperGuide/ApiReference-Query-DescribeImages.html
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
	 * Register Image
	 *
	 * Registers an AMI with Amazon EC2. Images must be registered before they can be launched via run_instances().
	 *
	 * @access public
	 * @param string $image_location (Required) Full path to your AMI manifest in Amazon S3 storage (i.e. mybucket/myimage.manifest.xml).
	 * @return TarzanHTTPResponse
	 * @see http://docs.amazonwebservices.com/AWSEC2/2007-03-01/DeveloperGuide/ApiReference-Query-RegisterImage.html
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
	 * Describe Image Attribute
	 *
	 * Returns information about an attribute of an AMI. Only one attribute may be specified per call.
	 *
	 * @access public
	 * @param string $image_id (Required) Unique ID of a machine image, returned by a call to register_image() or describe_images().
	 * @return TarzanHTTPResponse
	 * @see http://docs.amazonwebservices.com/AWSEC2/2007-03-01/DeveloperGuide/ApiReference-Query-DescribeImageAttribute.html
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
	 * Modify Image Attribute
	 *
	 * Modifies an attribute of an AMI.
	 *
	 * @access public
	 * @param string $image_id (Required) AMI ID to modify an attribute on.
 	 * @param string $attribute (Required) Specifies the attribute to modify. Supports 'launchPermission' and 'productCodes'.
 	 * @param array $opt Associative array of parameters which can have the following keys:
	 * <ul>
	 *   <li>string OperationType - (Required for 'launchPermission' Attribute) Specifies the operation to perform on the attribute. Supports 'add' and 'remove'.</li>
	 *   <li>string UserId.n - (Required for 'launchPermission' Attribute) User IDs to add to or remove from the 'launchPermission' attribute.</li>
	 *   <li>string UserGroup.n - (Required for 'launchPermission' Attribute) User groups to add to or remove from the 'launchPermission' attribute. Currently, only the 'all' group is available, specifiying all Amazon EC2 users.</li>
	 *   <li>string ProductCode.n - (Required for 'productCodes' Attribute) Attaches product codes to the AMI. Currently only one product code may be associated with an AMI. Once set, the product code can not be changed or reset.</li>
	 * </ul>
	 * @return TarzanHTTPResponse
	 * @see http://docs.amazonwebservices.com/AWSEC2/2007-03-01/DeveloperGuide/ApiReference-Query-ModifyImageAttribute.html
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
	 * Reset Image Attribute
	 *
	 * Resets an attribute of an AMI to its default value.
	 *
	 * @access public
	 * @param string $image_id (Required) Unique ID of a machine image, returned by a call to register_image() or describe_images().
	 * @return TarzanHTTPResponse
	 * @see http://docs.amazonwebservices.com/AWSEC2/2007-03-01/DeveloperGuide/ApiReference-Query-ResetImageAttribute.html
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
	 * Confirm Product Instance
	 *
	 * Returns true if the given product code is attached to the instance with the given instance id. 
	 * The operation returns false if the product code is not attached to the instance.
	 *
	 * @access public
	 * @param string $product_code (Required) The product code to confirm is attached to the instance.
	 * @param string $instance_id (Required) The instance to confirm.
	 * @return TarzanHTTPResponse
	 * @see http://docs.amazonwebservices.com/AWSEC2/2007-03-01/DeveloperGuide/ApiReference-Query-ConfirmProductInstance.html
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
	 * Describe Instances
	 *
	 * Returns information about instances owned by the user making the request.
	 *
	 * @access public
	 * @param array $opt Associative array of parameters which can have the following keys:
	 * <ul>
	 *   <li>string InstanceId.n - (Optional) Set of instances IDs to get the status of.</li>
	 * </ul>
	 * @return TarzanHTTPResponse
	 * @see http://docs.amazonwebservices.com/AWSEC2/2007-03-01/DeveloperGuide/ApiReference-Query-DescribeInstances.html
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
	 * Run Instances
	 *
	 * Launches a specified number of instances. A call to RunInstances is guaranteed to start no 
	 * fewer than the requested minimum. If there is insufficient capacity available then no 
	 * instances will be started. Amazon EC2 will make a best effort attempt to satisfy the 
	 * requested maximum values.
	 *
	 * @access public
	 * @param string ImageId (Required) ID of the AMI to launch instances based on.
	 * @param integer MinCount (Required) Minimum number of instances to launch.
	 * @param integer MaxCount (Required) Maximum number of instances to launch.
	 * @param array $opt Associative array of parameters which can have the following keys:
	 * <ul>
	 *   <li>string KeyName - (Optional) Name of the keypair to launch instances with.</li>
	 *   <li>string SecurityGroup.n - (Optional) Names of the security groups to associate the instances with.</li>
	 *   <li>string UserData - (Optional) The user data available to the launched instances. This should be base64-encoded. See the UserDataType data type for encoding details.</li>
	 *   <li>string AddressingType - (Optional) The addressing scheme to launch the instance with. The addressing type can be direct or public. In the direct scheme the instance has one IP address that is not NAT'd. For the public scheme the instance has a NAT'd IP address. See the section called "Instance Addressing" for more information on instance addressing.</li>
	 * </ul>
	 * @return TarzanHTTPResponse
	 * @see http://docs.amazonwebservices.com/AWSEC2/2007-03-01/DeveloperGuide/ApiReference-Query-RunInstances.html
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
	 * Terminate Instances
	 *
	 * Shuts down one or more instances. This operation is idempotent and terminating an instance that is 
	 * in the process of shutting down (or already terminated) will succeed.
	 *
	 * @access public
	 * @param array $opt Associative array of parameters which can have the following keys:
	 * <ul>
	 *   <li>string InstanceId.1 - (Required) One instance ID returned from previous calls to RunInstances.</li>
	 *   <li>string InstanceId.n - (Optional) More than one instance IDs returned from previous calls to RunInstances.</li>
	 * </ul>
	 * @return TarzanHTTPResponse
	 * @see http://docs.amazonwebservices.com/AWSEC2/2007-03-01/DeveloperGuide/ApiReference-Query-TerminateInstances.html
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
	 * Create Key Pair
	 *
	 * Creates a new 2048 bit RSA keypair and returns a unique ID that can be used to reference this 
	 * keypair when launching new instances.
	 *
	 * @access public
	 * @param string $key_name (Required) Unique name for this key.
	 * @return TarzanHTTPResponse
	 * @see http://docs.amazonwebservices.com/AWSEC2/2007-03-01/DeveloperGuide/ApiReference-Query-CreateKeyPair.html
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
	 * Delete Key Pair
	 *
	 * Deletes a keypair.
	 *
	 * @access public
	 * @param string $key_name (Required) Unique name for this key.
	 * @return TarzanHTTPResponse
	 * @see http://docs.amazonwebservices.com/AWSEC2/2007-03-01/DeveloperGuide/ApiReference-Query-DeleteKeyPair.html
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
	 * Describe Key Pairs
	 *
	 * Returns information about keypairs available for use by the user making the request. Selected 
	 * keypairs may be specified or the list may be left empty if information for all registered 
	 * keypairs is required.
	 *
	 * @access public
	 * @param array $opt Associative array of parameters which can have the following keys:
	 * <ul>
	 *   <li>string KeyName.n - (Optional) One or more keypair IDs to describe.</li>
	 * </ul>
	 * @return TarzanHTTPResponse
	 * @see http://docs.amazonwebservices.com/AWSEC2/2007-03-01/DeveloperGuide/ApiReference-Query-DescribeKeyPairs.html
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
	 * Authorize Security Groups Ingress
	 *
	 * Adds permissions to a security group.
	 * 
	 * Permissions are specified in terms of the IP protocol (TCP, UDP or ICMP), the source of the 
	 * request (by IP range or an Amazon EC2 user-group pair), source and destination port ranges 
	 * (for TCP and UDP), and ICMP codes and types (for ICMP). When authorizing ICMP, -1 may be 
	 * used as a wildcard in the type and code fields.
	 * 
	 * Permission changes are propagated to instances within the security group being modified as 
	 * quickly as possible. However, a small delay is likely, depending on the number of instances 
	 * that are members of the indicated group.
	 * 
	 * When authorizing a user/group pair permission, GroupName, SourceSecurityGroupName and 
	 * SourceSecurityGroupOwnerId must be specified. When authorizing a CIDR IP permission, 
	 * GroupName, IpProtocol, FromPort, ToPort and CidrIp must be specified. Mixing these two 
	 * types of parameters is not allowed.
	 *
	 * @access public
	 * @param string $group_name (Required) Name of the security group to modify.
	 * @param array $opt Associative array of parameters which can have the following keys:
	 * <ul>
	 *   <li>string SourceSecurityGroupName - (Required when authorizing user/group pair permission) Name of security group to authorize access to when operating on a user/group pair.</li>
	 *   <li>string SourceSecurityGroupOwnerId - (Required when authorizing user/group pair permission) Owner of security group to authorize access to when operating on a user/group pair.</li>
	 *   <li>string IpProtocol - (Required when authorizing CIDR IP permission) IP protocol to authorize access to when operating on a CIDR IP. Valid values are 'tcp', 'udp' and 'icmp'.</li>
	 *   <li>integer FromPort - (Required when authorizing CIDR IP permission) Bottom of port range to authorize access to when operating on a CIDR IP. This contains the ICMP type if ICMP is being authorized.</li>
	 *   <li>integer ToPort - (Required when authorizing CIDR IP permission) Top of port range to authorize access to when operating on a CIDR IP. This contains the ICMP code if ICMP is being authorized.</li>
	 *   <li>string CidrIp - (Required when authorizing CIDR IP permission) CIDR IP range to authorize access to when operating on a CIDR IP.</li>
	 * </ul>
	 * @return TarzanHTTPResponse
	 * @see http://docs.amazonwebservices.com/AWSEC2/2007-03-01/DeveloperGuide/ApiReference-Query-AuthorizeSecurityGroupIngress.html
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
	 * Create Security Group
	 *
	 * Every instance is launched in a security group. If none is specified as part of the launch request 
	 * then instances are launched in the default security group. Instances within the same security group 
	 * have unrestricted network access to one another. Instances will reject network access attempts from 
	 * other instances in a different security group. As the owner of instances you may grant or revoke 
	 * specific permissions using the AuthorizeSecurityGroupIngress and RevokeSecurityGroupIngress operations.
	 *
	 * @access public
	 * @param string $group_name (Required) Name for the new security group.
	 * @param string $group_description (Required) Description of the new security group.
	 * @return TarzanHTTPResponse
	 * @see http://docs.amazonwebservices.com/AWSEC2/2007-03-01/DeveloperGuide/ApiReference-Query-CreateSecurityGroup.html
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
	 * Delete Security Group
	 *
	 * Deletes a security group. If an attempt is made to delete a security group and any instances exist 
	 * that are members of that group a fault is returned.
	 *
	 * @access public
	 * @param string $group_name (Required) Name for the new security group.
	 * @return TarzanHTTPResponse
	 * @see http://docs.amazonwebservices.com/AWSEC2/2007-03-01/DeveloperGuide/ApiReference-Query-DeleteSecurityGroup.html
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
	 * Describe Security Groups
	 *
	 * Returns information about security groups owned by the user making the request. An optional list 
	 * of security group names may be provided to request information for those security groups only. 
	 * If no security group names are provided, information of all security groups will be returned. 
	 * If a group is specified that does not exist a fault is returned.
	 *
	 * @access public
	 * @param array $opt Associative array of parameters which can have the following keys:
	 * <ul>
	 *   <li>string GroupName.n - (Optional) List of security groups to describe.</li>
	 * </ul>
	 * @return TarzanHTTPResponse
	 * @see http://docs.amazonwebservices.com/AWSEC2/2007-03-01/DeveloperGuide/ApiReference-Query-DescribeSecurityGroups.html
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
	 * Revoke Security Groups Ingress
	 *
	 * Revokes existing permissions that were previously granted to a security group. The permissions 
	 * to revoke must be specified using the same values originally used to grant the permission.
	 * 
	 * Permissions are specified in terms of the IP protocol (TCP, UDP or ICMP), the source of the 
	 * request (by IP range or an Amazon EC2 user-group pair), source and destination port ranges 
	 * (for TCP and UDP), and ICMP codes and types (for ICMP). When authorizing ICMP, -1 may be 
	 * used as a wildcard in the type and code fields.
	 * 
	 * Permission changes are propagated to instances within the security group being modified as 
	 * quickly as possible. However, a small delay is likely, depending on the number of instances 
	 * that are members of the indicated group.
	 * 
	 * When revoking a user/group pair permission, GroupName, SourceSecurityGroupName and 
	 * SourceSecurityGroupOwnerId must be specified. When authorizing a CIDR IP permission, 
	 * GroupName, IpProtocol, FromPort, ToPort and CidrIp must be specified. Mixing these two 
	 * types of parameters is not allowed.
	 *
	 * @access public
	 * @param string $group_name (Required) Name of the security group to modify.
	 * @param array $opt Associative array of parameters which can have the following keys:
	 * <ul>
	 *   <li>string SourceSecurityGroupName - (Required when revoking user/group pair permission) Name of security group to authorize access to when operating on a user/group pair.</li>
	 *   <li>string SourceSecurityGroupOwnerId - (Required when revoking user/group pair permission) Owner of security group to authorize access to when operating on a user/group pair.</li>
	 *   <li>string IpProtocol - (Required when revoking CIDR IP permission) IP protocol to authorize access to when operating on a CIDR IP. Valid values are 'tcp', 'udp' and 'icmp'.</li>
	 *   <li>int FromPort - (Required when revoking CIDR IP permission) Bottom of port range to authorize access to when operating on a CIDR IP. This contains the ICMP type if ICMP is being authorized.</li>
	 *   <li>int ToPort - (Required when revoking CIDR IP permission) Top of port range to authorize access to when operating on a CIDR IP. This contains the ICMP code if ICMP is being authorized.</li>
	 *   <li>string CidrIp - (Required when revoking CIDR IP permission) CIDR IP range to authorize access to when operating on a CIDR IP.</li>
	 * </ul>
	 * @return TarzanHTTPResponse
	 * @see http://docs.amazonwebservices.com/AWSEC2/2007-03-01/DeveloperGuide/ApiReference-Query-RevokeSecurityGroupIngress.html
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