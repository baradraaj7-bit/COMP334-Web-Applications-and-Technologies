
<?php

class Ticket
{
    // Properties
    private $ticketID;
    private $customerName;
    private $email;
    private $location;
    private $description;
    private $submittedDate;
    private $status;
    private $emergencyLevel;
    private $assignedDate;
    private $assignedStaff;
    private $ticketImageName;


    // Constructor
    public function __construct(
        $ticketID,
        $customerName,
        $email,
        $location,
        $description,
        $submittedDate,
        $status,
        $emergencyLevel,
        $assignedDate,
        $assignedStaff,
        $ticketImageName
    ) {
        $this->ticketID = $ticketID;
        $this->customerName = $customerName;
        $this->email = $email;
        $this->location = $location;
        $this->description = $description;
        $this->submittedDate = $submittedDate;
        $this->status = $status;
        $this->emergencyLevel = $emergencyLevel;
        $this->assignedDate = $assignedDate;
        $this->assignedStaff = $assignedStaff;
        $this->ticketImageName = $ticketImageName;
    }


    // Getters

    public function getTicketID()
    {
        return $this->ticketID;
    }

    public function getCustomerName()
    {
        return $this->customerName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getSubmittedDate()
    {
        return $this->submittedDate;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getEmergencyLevel()
    {
        return $this->emergencyLevel;
    }

    public function getAssignedDate()
    {
        return $this->assignedDate;
    }

    public function getAssignedStaff()
    {
        return $this->assignedStaff;
    }

    public function getTicketImageName()
    {
        return $this->ticketImageName;
    }


    // Setters

    public function setTicketID($ticketID)
    {
        $this->ticketID = $ticketID;
    }

    public function setCustomerName($customerName)
    {
        $this->customerName = $customerName;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setLocation($location)
    {
        $this->location = $location;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setSubmittedDate($submittedDate)
    {
        $this->submittedDate = $submittedDate;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setEmergencyLevel($emergencyLevel)
    {
        $this->emergencyLevel = $emergencyLevel;
    }

    public function setAssignedDate($assignedDate)
    {
        $this->assignedDate = $assignedDate;
    }

    public function setAssignedStaff($assignedStaff)
    {
        $this->assignedStaff = $assignedStaff;
    }

    public function setTicketImageName($ticketImageName)
    {
        $this->ticketImageName = $ticketImageName;
    }


    // Display Ticket Page

    public function displayTicketPage()
{
    if (!empty($this->ticketImageName)) {

        $imageHTML = "
            <li>
                <strong>Photo Uploaded:</strong>
                <br>
                <img src='images/{$this->ticketImageName}'
                     alt='Ticket Image'
                     class='ticket-image'>
            </li>
        ";

    } else {

        $imageHTML = "
            <li>
                <strong>Photo Uploaded:</strong>
                No photo uploaded.
            </li>
        ";
    }

    return "
    <main>

        <h2>View Ticket: #{$this->ticketID}</h2>

        <p>
            Here is a summary of the information about
            #{$this->ticketID}:
        </p>

        <ul>

            <li>
                <strong>Submitted by Customer:</strong>
                {$this->customerName}
            </li>

            <li>
                <strong>Email:</strong>
                {$this->email}
            </li>

            <li>
                <strong>Location:</strong>
                {$this->location}
            </li>

            <li>
                <strong>Issue Description:</strong>
                {$this->description}
            </li>

            <li>
                <strong>Urgency Level:</strong>
                {$this->emergencyLevel}
            </li>

            <li>
                <strong>Submitted Date:</strong>
                {$this->submittedDate}
            </li>

            <li>
                <strong>Ticket Status:</strong>
                {$this->status}
            </li>

            <li>
                <strong>Assigned to:</strong>
                {$this->assignedStaff}
                on
                {$this->assignedDate}
            </li>

            {$imageHTML}

        </ul>

    </main>
    ";
}


    // Display Table

    public function displayTable()
    {
        return "
        <tr>

            <td>
                <a href='view.php?id={$this->ticketID}'>
                    {$this->ticketID}
                </a>
            </td>

            <td>
                {$this->description}
            </td>

            <td>
                {$this->submittedDate}
            </td>

            <td>
                {$this->customerName}
            </td>

            <td>
                {$this->emergencyLevel}
            </td>

            <td>
                {$this->status}
            </td>

            <td>
                 <a href='view.php?id={$this->ticketID}'>
                 <img src='images/view.png' alt='View Ticket'>
             </a>

         <a href='assign.php?id={$this->ticketID}'>
            <img src='images/assign.png' alt='Assign Ticket'>
    </a>

</td>

        </tr>
        ";
    }
}

public function disbly(){

return "
<tr>
<td>{$this ->id}</td>
<td>{$this->name}</td>

</tr>
";


}

?>