<h2>Choose an action</h2>
<div><?php echo $message; ?></div>
<div>

  <table>
    <tr>
      <td>
        <a class='menuLink' href = '?controller=admin&action=addPost'><li>Add A Post</li></a>
        <a class='menuLink' href = '?controller=admin&action=deletePosts'><li>Delete Posts</li></a>
        <a class='menuLink' href = '?controller=admin&action=addTag'><li>Add A Tag</li></a>
        <a class='menuLink' href = '?controller=admin&action=addCat'><li>Add A Catagory</li></a>
        <a class='menuLink' href = '?controller=admin&action=linkTag'><li>Link tags to Catagory</li></a>
      </td>
      <td>
        <a class='menuLink' href = '?controller=evaluation&action=addCriteria'><li>Add Criteria</li></a>
        <a class='menuLink' href = '?controller=evaluation&action=addCriteriaSet'><li>Create a Criteria Set</li></a>
      </td>
      <td>
        <a class='menuLink' href = '?controller=user&action=addUser'><li>Register User</li></a>
        <a class='menuLink' href = '?controller=user&action=editUser'><li>Edit User</li></a>
      </td>
    </tr>
  </table>
</div>
